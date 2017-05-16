function ViewModel() {
    var self = this;

    self.loading = ko.observable(false);
    self.platform = ko.observable(0);
    self.username = ko.observable("");
    self.player = ko.observable(null);
    self.leaderboard = ko.observable(null);
    self.clan = ko.observable(null);
    self.isPopupVisible = ko.computed(function () {
        var name = "getapp";
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");

        if (parts.length === 2) {
            return parts.pop().split(";").shift() === 'true';
        }

        return true;
    });

    $('.zmdi-close').click(function(e) {
        var input = $(e.currentTarget).siblings('input');
        input.val('');
        input.focus();
    });

    self.searchPlayer = function(leaderboard) {
        self.loading(true);
        var jsonUrl = "/api/?console=" + self.platform() + "&user=" + self.username();
        return $.getJSON(jsonUrl, function(json) {
            self.loading(false);
            self.showError(json.Info);

            if (leaderboard === undefined) {
                ga('send', 'event', 'Search Player', json.Info.Message, self.platform() + ' - ' + self.username());
            } else {
                ga('send', 'event', 'Leaderboard', json.Info.Message, self.platform() + ' - ' + self.username());
            }

            if (json.Info.Status !== 'Error') {
                self.player(json.Response);
                self.reloadImage();
                self.scrollTo('#playerCards');
                $('.dropdown-button').dropdown();
                
                if (typeof (history.pushState) !== "undefined") {
                    var obj = { Title: self.player().displayName, Url: self.getNewUrl() };
                    history.pushState(obj, obj.Title, obj.Url);
                }
            } else {
                var params = window.location.pathname.split('/').filter(function(item) {
                    return item !== "";
                });

                if (params.length > 0) {
                    if (params[0] === "xbox") {
                        self.platform(1);
                        self.username(self.player().xbox.displayName);
                    } else {
                        self.platform(2);
                        self.username(self.player().playstation.displayName);
                    }
                }
            }
        });
    };

    self.allCharacters = ko.computed(function() {
        var characters = [];

        if (self.player() !== null) {
            if (self.player().playstation !== null) {
                self.player().playstation.characters.forEach(function(item) {
                    item.membershipType = 2;
                    characters.push(item);
                });
            }

            if (self.player().xbox !== null) {
                self.player().xbox.characters.forEach(function(item) {
                    item.membershipType = 1;
                    characters.push(item);
                });
            }
        }

        return characters.sort(function(item1, item2) {
            return item2.timePlayed - item1.timePlayed;
        });
    });

    self.loadLeaderboard = function(page) {
        var jsonUrl = "/api/?leaderboard&page=" + page + "&" + new Date().getTime();
        return $.getJSON(jsonUrl, function(json) {
            self.loading(false);
            self.showError(json.Info);
            self.leaderboard(json.Response);
        });
    };

    self.loadClan = function(id, page) {
        var jsonUrl = "/api/?clan=" + id + "&page=" + page;
        return $.getJSON(jsonUrl, function(json) {
            self.loading(false);
            self.showError(json.Info);
            self.clan(json.Response);

            for (var key in self.clan().players) {
                if (self.clan().players.hasOwnProperty(key)) {
                    var otherJsonUrl = "/api/?console=" + self.clan().players[key].membershipType + "&user=" + self.clan().players[key].displayName;
                    $.getJSON(otherJsonUrl, function (json) {
                        if (json.Info.Status !== Error) {
                            for (var player in self.clan().players) {
                                if (self.clan().players.hasOwnProperty(player)) {
                                    if (json.Response.xbox && self.clan().players[player].membershipId === json.Response.xbox.membershipId) {
                                        self.clan().players[player].timePlayed = json.Response.xbox.timePlayed;
                                    } else if (json.Response.playstation && self.clan().players[player].membershipId === json.Response.playstation.membershipId) {
                                        self.clan().players[player].timePlayed = json.Response.playstation.timePlayed;
                                    }
                                }
                            }

                            self.clan.valueHasMutated();
                        }
                    });
                }
            }
        });
    };

    self.share = function(href) {
        window.open(href, "_blank", "toolbar=no, scrollbars=no, resizable=yes, top=0, left=0, width=500, height=300");
    };

    self.sponsorText = ko.observable({text:"",link:""});

    self.changeSponsorText = function() {
        var strings = [
            {text: "See how you can change for hybrid cloud with HDCE",link: "https://www.hdce.ca/en/serveur-vm-dedier/"},
            {text: "Why is this website accessible? Because of HDCE High Availability Hosting",link: "https://www.hdce.ca/en/serveur-vm-dedier/"},
            {text: "Tired of asking your colleague's availability? HDCE Cloud Mail got you covered",link: "https://www.hdce.ca/en/services-offerts/courriels-collaboratifs/"},
            {text: "You can count on us with our Cloud Accounting Solution!",link: "https://www.hdce.ca/en/systeme-comptable-cloud/"},
            {text: "Tired of having to check your servers each day? HDCE Cloud Monitoring",link: "https://www.hdce.ca/en/services-offerts/telesurveillance-des-infrastructures/"},
            {text: "Link-File, an exclusivity HDCE, gives you the ability to send Terabytes through emails",link: "https://www.hdce.ca/en/linkfile/"}
        ];
        var random = Math.floor(Math.random() * strings.length);
        self.sponsorText(strings[random]);
    };

    self.getNewUrl = function() {
        var platform = '';

        if (self.player() !== null) {
            if (self.platform() === 1) {
                if (self.player().xbox !== null) {
                    platform = 'xbox';
                } else if (self.player().playstation !== null) {
                    platform = 'playstation';
                } else {
                    return window.location.protocol + '//' + window.location.hostname;
                }
            } else if (self.platform() === 2) {
                if (self.player().playstation !== null) {
                    platform = 'playstation';
                } else if (self.player().xbox !== null) {
                    platform = 'xbox';
                } else {
                    return window.location.protocol + '//' + window.location.hostname;
                }
            } else {
                return window.location.protocol + '//' + window.location.hostname;
            }
        } else {
            return window.location.protocol + '//' + window.location.hostname;
        }

        return window.location.protocol + '//' + window.location.hostname + '/' + platform + '/' + self.username().toLowerCase();
    };

    self.isActivePlayer = function(entry) {
        if (self.player() !== null) {
            if (self.player().playstation !== null && self.player().playstation.membershipId === entry.membershipId) {
                return true
            }

            if (self.player().xbox !== null && self.player().xbox.membershipId === entry.membershipId) {
                return true;
            }
        }

        return false;
    };

    self.scrollTo = function(elem) {
        $("html, body").animate({ scrollTop: $(elem).offset().top }, 1000);
    };

    self.reloadImage = function() {
        function pad(num, size) {
            var s = num+"";
            while (s.length < size) s = "0" + s;
            return s;
        }

        $('body').css({'background-image': 'url(/img/background/' +pad(Math.floor(Math.random() * 50), 3) + '.jpg)'});
    };

    self.load = function() {
        self.reloadImage();
        self.changeSponsorText();
        
        $(document).scroll(function() {
            var y = $(this).scrollTop();
            if (y > 0) {
                $('#returnToTop').removeClass("hide").fadeIn();
            } else {
                $('#returnToTop').addClass("hide");
            }
        });

        self.loadLeaderboard(1).then(function() {
            var params = window.location.pathname.split('/').filter(function(item) {
                return item !== "";
            });

            if (params.length > 0) {
                if (params[0] === "xbox") {
                    self.platform(1);
                    self.username(decodeURI(params[1]));
                    self.searchPlayer();
                } else {
                    self.platform(2);
                    self.username(decodeURI(params[1]));
                    self.searchPlayer();
                }
            }
        });
    };

    self.firstLeaderboardPage = function() {
        ga('send', 'event', 'Leaderboard', 'First Page');
        var page = self.leaderboard().page;
        if (page !== 1) {
            self.loadLeaderboard(1);
        }
    };

    self.previousLeaderboardPage = function() {
        ga('send', 'event', 'Leaderboard', 'Previous Page');
        var page = self.leaderboard().page;
        if (page !== 1) {
            self.loadLeaderboard(parseInt(page) - 1);
        }
    };

    self.nextLeaderboardPage = function() {
        ga('send', 'event', 'Leaderboard', 'Next Page');
        var page = self.leaderboard().page;
        if ((page * 10) < self.leaderboard().totalPlayers) {
            self.loadLeaderboard(parseInt(page) + 1);
        }
    };

    self.firstClanPage = function() {
        ga('send', 'event', 'Clan', 'First Page');
        var page = self.clan().page;
        if (page !== 1) {
            self.loadClan(self.clan().id, 1);
        }
    };

    self.previousClanPage = function() {
        ga('send', 'event', 'Clan', 'Previous Page');
        var page = self.clan().page;
        if (page !== 1) {
            self.loadClan(self.clan().id, parseInt(page) - 1);
        }
    };

    self.nextClanPage = function() {
        ga('send', 'event', 'Clan', 'Next Page');
        var page = self.clan().page;
        if ((page * 10) < self.clan().total) {
            self.loadClan(self.clan().id, parseInt(page) + 1);
        }
    };

    self.showError = function(json) {
        if (json.Status !== "Success") {
            var weight = "yellow darken-3";
            if (json.Status === "Error") {
                weight = "red darken-1";
            }
            var message = json.Message.replace(new RegExp('\r?\n', 'g'), '<br />');
            Materialize.toast(message, 3000, weight);
        }
    }
}

ko.bindingHandlers.hours = {
    update: function(element, valueAccessor, allBindings) {
        var value = ko.unwrap(valueAccessor());
        var format = allBindings.get('format');
        var hours = Math.floor(value / (60 * 60));

        if (format) {
            var spl = format.split('?', 2);
            $(element).text(spl[0] + hours + "h" + spl[1]);
        } else {
            $(element).text(hours + "h");
        }
    }
};

ko.bindingHandlers.time = {
    update: function(element, valueAccessor) {
        var value = ko.unwrap(valueAccessor());
        var years = Math.floor(value / (7 * 24 * 60 * 60 * 52));

        if (years > 1) {
            years = years + " years ";
        } else if (years > 0) {
            years = years + " year ";
        } else {
            years = "";
        }

        var weeks = Math.floor(value / (7 * 24 * 60 * 60)) % 52;

        if (weeks > 1) {
            weeks = weeks + " weeks ";
        } else if (weeks > 0) {
            weeks = weeks + " week ";
        } else {
            weeks = "";
        }

        var days = Math.floor(value / (24 * 60 * 60)) % 7;

        if (days > 1) {
            days = days + " days ";
        } else if (days > 0) {
            days = days + " day ";
        } else {
            days = "";
        }

        var hours = Math.floor(value / (60 * 60)) % 24;

        if (hours > 1) {
            hours = hours + " hours ";
        } else if (hours > 0) {
            hours = hours + " hour ";
        } else {
            hours = "";
        }

        var minutes = Math.floor(value / 60) % 60;

        if (minutes > 1) {
            minutes = minutes + " minutes ";
        } else if (minutes > 0) {
            minutes = minutes + " minute ";
        } else {
            minutes = "";
        }

        var seconds = value % 60;

        if (seconds > 1) {
            seconds = seconds + " seconds";
        } else if (seconds > 0) {
            seconds = seconds + " second";
        } else {
            seconds = "";
        }

        $(element).text(years + weeks + days + hours + minutes + seconds);
    }
};