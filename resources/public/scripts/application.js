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
                    var displayName = "";

                    if (account.bungieNetDisplayName() !== '') {
                        displayName = account.bungieNetDisplayName();
                    } else {
                        displayName = account.displayName;
                    }

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
            self.statsVisible(true);

            Request('/bungie/fetchAccount', {
                membershipType: membershipType,
                membershipId: membershipId
            }, function(response) {
                self.populateAccounts(response);
            });
        };

        self.fetchAccounts = function () {
            self.statsVisible(true);

            if (self.input().trim() !== "") {
                var inputs = self.input().trim().split(',');

                inputs.forEach(function(input) {
                    Request('/bungie/fetchAccounts', {
                        membershipType: -1,
                        displayName: input.trim()
                    }, function (response) {
                        if (response.ErrorCode === 1 && !Array.isArray(response.Response)) {
                            self.populateAccounts(response);
                        } else {
                            self.input("");
                            UIkit.notification('No account found.', {status: 'danger'});
                        }
                    }, function (response) {
                        self.input("");
                        UIkit.notification((response.Message || 'No account found.'), {status: 'danger'});
                    });
                });
            }
        };

        self.populateAccounts = function (response) {
            self.input("");

            if (response.hasOwnProperty('Response') && response.Response.hasOwnProperty('destinyMemberships')) {
                response.Response.destinyMemberships.forEach(function (item) {
                    var account = new Account(item);

                    if (response.Response.hasOwnProperty('bungieNetUser')) {
                        account.bungieNetDisplayName(response.Response.bungieNetUser.displayName);
                        account.bungieNetMembershipId(response.Response.bungieNetUser.membershipId);
                    }

                    var exisitingAccount = self.accounts().filter(function (item) {
                        return item.membershipId === account.membershipId
                            && item.membershipType === account.membershipType
                            && item.gameVersion === account.gameVersion
                    });

                    if (exisitingAccount.length === 0) {
                        self.accounts.push(account);
                        self.accounts.valueHasMutated();
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

                        self.fetchStats(account);
                    }
                });
            }
        };

        self.fetchStats = function (account) {
            Request('/bungie/fetchCharacterStats', {
                membershipType: account.membershipType,
                membershipId: account.membershipId,
                version: account.gameVersion
            }, function (response) {
                if (response.ErrorCode === 1) {
                    self.populateStats(response, account);
                } else {
                    account.message(response.Message);
                    account.loading(false);
                    self.accounts.valueHasMutated();
                    setTimeout(function () {
                        self.removeAccount(account);
                    }, 5000);
                }
            }, function (response) {
                account.message(response.Message);
                account.loading(false);
                self.accounts.valueHasMutated();
                setTimeout(function () {
                    self.removeAccount(account);
                }, 5000);
            });
        };

        /*self.fetchStats = function (account) {
            Request('/bungie/fetchStats', {
                membershipType: account.membershipType,
                membershipId: account.membershipId,
                version: account.gameVersion
            }, function (response) {
                if (response.ErrorCode === 1) {
                    self.populateStats(response, account);
                } else {
                    account.message(response.Message);
                    account.loading(false);
                    self.accounts.valueHasMutated();
                    setTimeout(function () {
                        self.removeAccount(account);
                    }, 5000);
                }
            }, function (response) {
                account.message(response.Message);
                account.loading(false);
                self.accounts.valueHasMutated();
                setTimeout(function () {
                    self.removeAccount(account);
                }, 5000);
            });
        };*/

        self.populateStats = function (response, account) {
            if (response.hasOwnProperty('Response')) {
                var characters = [];

                response.Response.characters.forEach(function (item) {
                    var character = new Character(item);

                    if (character.deleted) {
                        account.timeWasted(account.timeWasted() + character.seconds());
                    }

                    account.timePlayed(account.timePlayed() + character.seconds());
                    characters.push(character);
                });

                if (characters.length > 0) {
                    characters.sort(function(left, right) {
                        return right.seconds() - left.seconds();
                    });
                    self.fetchCharacters(account, characters);
                } else {
                    account.loading(false);
                    self.accounts.valueHasMutated();
                }
            }
        };

        self.fetchCharacters = function (account, characters) {
            Request('/bungie/fetchCharacters', {
                membershipType: account.membershipType,
                membershipId: account.membershipId,
                gameVersion: account.gameVersion
            }, function (response) {
                if (response.ErrorCode === 1) {
                    self.populateCharacters(response, account, characters);
                } else {
                    account.message(response.Message);
                    account.loading(false);
                    self.accounts.valueHasMutated();
                    setTimeout(function() {
                        self.removeAccount(account);
                    }, 5000);
                }
            }, function(response) {
                account.message(response.Message);
                account.loading(false);
                self.accounts.valueHasMutated();
                setTimeout(function() {
                    self.removeAccount(account);
                }, 5000);
            });
        };

        self.populateCharacters = function (response, account, characters) {
            if (response.hasOwnProperty('Response')) {
                var Manifest = account.gameVersion === 1 ? ManifestD1 : ManifestD2;
                var data = {};

                if (account.gameVersion === 1) {
                    data = response.Response.data;
                } else {
                    data = response.Response.profile.data;
                }

                account.lastPlayed(data.dateLastPlayed);

                characters.forEach(function (character) {
                    var characterData = {};
                    var genderType = "";

                    if (account.gameVersion === 1) {
                        characterData = data.characters.filter(function (item) {
                            return item.characterBase.characterId === character.characterId;
                        });

                        if (characterData.length === 1) {
                            genderType = Manifest.Genders[characterData[0].characterBase.genderHash].genderType;
                            character.gender = Manifest.Genders[characterData[0].characterBase.genderHash].genderName;
                            character.charClass = Manifest.Classes[characterData[0].characterBase.classHash]['className' + (genderType ? 'Female' : 'Male')];
                            character.race = Manifest.Races[characterData[0].characterBase.raceHash]['raceName' + (genderType ? 'Female' : 'Male')];
                            character.level = characterData[0].characterBase.powerLevel;
                            character.emblemPath(characterData[0].emblemPath);
                            character.backgroundPath(characterData[0].backgroundPath);
                        }
                    } else {
                        var charactersObj = response.Response.characters.data;
                        var charactersArray = Object.keys(charactersObj).map(function(key){ return charactersObj[key] });
                        characterData = charactersArray.filter(function (item) {
                            return item.characterId === character.characterId;
                        });

                        if (characterData.length === 1) {
                            genderType = Manifest.Genders[characterData[0].genderHash].genderType;
                            character.gender = Manifest.Genders[characterData[0].genderHash].displayProperties.name;
                            character.charClass = Manifest.Classes[characterData[0].classHash].genderedClassNames[genderType ? 'Female' : 'Male'];
                            character.race = Manifest.Races[characterData[0].raceHash].genderedRaceNames[genderType ? 'Female' : 'Male'];
                            character.level = characterData[0].light;
                            character.emblemPath(characterData[0].emblemPath);
                            character.backgroundPath(characterData[0].emblemBackgroundPath);
                        }
                    }

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