define([
    'knockout',
    'masonry',
    'account',
    'character',
    'leaderboard',
    'uikit',
    'apirequest',
    'request',
    'json!/manifests/manifest_D1.json',
    'json!/manifests/manifest_D2.json'
], function(ko, Masonry, Account, Character, Leaderboard, UIkit, APIRequest, Request, ManifestD1, ManifestD2) {
    var Application = function(searchTerm) {
        var self = this;

        self.loading = ko.observable(false);
        self.currentAccountNames = [];

        self.grid = $('#grid');
        self.masonry = new Masonry(self.grid[0], {"itemSelector": ".uk-grid-selector"});
        self.mainVisible = ko.observable(searchTerm === '');
        self.statsVisible = ko.observable(false);
        self.statsVisible.subscribe(function (value) {
            if (value) {
                self.showLeaderboard();
            }
        });
        self.detailedView = ko.observable(true);
        self.toggleDetailedView = function() {
            self.detailedView(!self.detailedView());
            self.accounts.valueHasMutated();
        };

        self.leaderboard = new Leaderboard();
        self.isLeaderboardShown = ko.observable(false);
        self.accounts = ko.observableArray([]);
        self.accounts.subscribe(function () {
            self.currentAccountNames = [];
            self.accounts().forEach(function(account) {
                if (account.constructor.name === "Account") {
                    var displayName = account.displayName;

                    var filter = self.currentAccountNames.filter(function (item) {
                        return item === displayName.toLowerCase();
                    });

                    if (filter.length === 0) {
                        self.currentAccountNames.push(displayName.toLowerCase());
                    }
                }
            });
            if (!window.location.origin) {
                window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
            }
            if (self.currentAccountNames.length > 0) {
                if (window.location.pathname === "/" || window.location.pathname !== "/search/" + self.currentAccountNames.join(',')) {
                    window.history.pushState(self.currentAccountNames, document.title, window.location.origin + '/search/' + self.currentAccountNames.join(','));
                }
            }

            setTimeout(function() {
                self.masonry.reloadItems();
                self.masonry.layout();
                self.accounts().forEach(function(item) {
                    item.visible(true);
                });
            }, 1);
        });
        self.input = ko.observable('');
        self.hoursMode = ko.observable(true);

        self.toggleTimeFormat = function () {
            self.hoursMode(!self.hoursMode());
            self.accounts.valueHasMutated();
        };

        self.removeAccount = function (item) {
            item.visible(false);
            setTimeout(function() {
                self.accounts.remove(item);

                if (item.constructor.name === "Leaderboard") {
                    self.isLeaderboardShown(false);
                }
            }, 500);
        };

        self.showLeaderboard = function () {
            if (!self.isLeaderboardShown()) {
                if (self.statsVisible()) {
                    self.accounts.push(self.leaderboard);
                    setTimeout(function() {
                        self.isLeaderboardShown(true);
                    }, 500);
                } else {
                    self.statsVisible(true);
                    $('html, body').animate({
                        scrollTop: $("#stats").offset().top
                    }, 500, "swing", function () {
                        self.mainVisible(false);
                        UIkit.sticky('.sticky', {
                            'sel-target': '#sticky-navbar',
                            'cls-active': 'uk-navbar-sticky',
                            offset: 0,
                            top: 0
                        });
                    });
                }
            }
        };

        self.statsVisible(searchTerm !== '');

        self.fetchAccount = function (membershipType, membershipId) {
            self.loading(true);
            Request('/bungie/getMembership', {
                membershipType: membershipType,
                membershipId: membershipId
            }, function(response) {
                self.populateAccounts(response);
            }, function() {

            }, function() {
                self.loading(false);
            });
        };

        self.fetchAccounts = function () {
            if (self.input().trim() !== "") {
                var inputs = self.input().trim().split(',');

                inputs.forEach(function(input) {
                    self.loading(true);

                    Request('/bungie/fetchAccounts', {
                        membershipType: -1,
                        displayName: input.trim()
                    }, function (response) {
                        if (response.code === 1 && !Array.isArray(response.response)) {
                            self.populateAccounts(response);
                        } else {
                            self.input("");
                            UIkit.notification('No account found.', {status: 'danger'});
                        }
                    }, function (response) {
                        self.input("");
                        UIkit.notification((response.message || 'No account found.'), {status: 'danger'});
                    }, function() {
                        self.loading(false);
                    });
                });
            }
        };

        self.populateAccounts = function (response) {
            self.input("");

            if (response.hasOwnProperty('response') && response.response.hasOwnProperty('destinyAccounts') && response.response.destinyAccounts) {
                response.response.destinyAccounts.forEach(function (item) {
                    var account = new Account(item);

                    if (response.response.hasOwnProperty('bungieNetUser') && response.response.bungieNetUser) {
                        account.bungieNetDisplayName(response.response.bungieNetUser.displayName);
                        account.bungieNetMembershipId(response.response.bungieNetUser.membershipId);
                    }

                    var exisitingAccount = self.accounts().filter(function (item) {
                        return item.membershipId === account.membershipId
                            && item.membershipType === account.membershipType
                            && item.gameVersion === account.gameVersion
                    });

                    if (exisitingAccount.length === 0) {
                        self.accounts.push(account);
                        self.accounts.valueHasMutated();
                        self.statsVisible(true);
                        $('html, body').animate({
                            scrollTop: $('#stats').offset().top
                        }, 500, "swing", function () {
                            self.mainVisible(false);
                            UIkit.sticky('.sticky', {
                                'sel-target': '#sticky-navbar',
                                'cls-active': 'uk-navbar-sticky',
                                offset: 0,
                                top: 0
                            });
                        });

                        self.fetchCharacters(account);
                    }
                });
            }
        };

        self.fetchCharacters = function (account) {
            Request('/bungie/fetchCharacters', {
                membershipType: account.membershipType,
                membershipId: account.membershipId,
                gameVersion: account.gameVersion
            }, function (response) {
                if (response.code === 1) {
                    self.populateCharacters(response, account);
                } else {
                    account.message(response.message);
                    account.loading(false);
                    self.accounts.valueHasMutated();
                    setTimeout(function() {
                        self.removeAccount(account);
                    }, 5000);
                }
            }, function(response) {
                account.message(response.message);
                account.loading(false);
                self.accounts.valueHasMutated();
                setTimeout(function() {
                    self.removeAccount(account);
                }, 5000);
            });
        };

        self.populateCharacters = function (response, account) {
            if (response.hasOwnProperty('response')) {
                response.response.forEach(function (item) {
                    var character = new Character(item);

                    if (character.deleted) {
                        account.timeWasted(account.timeWasted() + character.timePlayed());
                    }

                    account.timePlayed(account.timePlayed() + character.timePlayed());
                    account.characters.push(character);
                });

                account.loading(false);
                self.accounts.valueHasMutated();
            }
        };

        if (searchTerm !== '') {
            self.input(searchTerm);
            self.fetchAccounts();
        }
    };

    return Application;
});