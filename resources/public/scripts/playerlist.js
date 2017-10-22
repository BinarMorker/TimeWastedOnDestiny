define(['knockout', 'player'], function(ko, Player) {
    return function PlayerList(leaderboard, gameVersion, platform) {
        var self = this;

        self.players = ko.observableArray([]);
        self.loading = ko.observable(true);
        self.page = ko.observable(1);
        self.totalPlayers = ko.observable(0);
        self.gameVersion = gameVersion;
        self.platform = platform;

        self.previous = function() {
            if (self.page() > 1) {
                self.page(self.page() - 1);
                self.load();
            }
        };

        self.next = function() {
            if (self.page() * 10 < self.totalPlayers()) {
                self.page(self.page() + 1);
                self.load();
            }
        };

        self.load = function () {
            self.loading(true);
            leaderboard.manager.GetPage(self.gameVersion, self.platform, self.page(), self.populateEntries, function () {
                self.loading(false);
            });
        };

        self.populateEntries = function (data) {
            self.players([]);

            if (data.response) {
                if (data.response.players && data.response.players.length > 0) {
                    data.response.players.forEach(function (item) {
                        self.players.push(new Player(item));
                    });
                }

                self.totalPlayers(data.response.totalPlayers);
            }

            self.loading(false);
            leaderboard.update();
        };

        self.loading(true);
        self.load();
    };
});