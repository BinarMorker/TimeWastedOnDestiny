define(['knockout', 'player', 'leaderboardmanager', 'playerlist'], function(ko, Player, LeaderboardManager, PlayerList) {
    return function Leaderboard(masonry) {
        var self = this;

        self.masonry = masonry;
        self.manager = new LeaderboardManager();
        self.players = ko.observableArray([]);
        self.loading = ko.observable(true);
        self.message = ko.observable(null);
        self.visible = ko.observable(false);
        self.lists = ko.observableArray([
            new PlayerList(self, 1, 2),
            new PlayerList(self, 1, 1),
            new PlayerList(self, 2, 2),
            new PlayerList(self, 2, 1),
            new PlayerList(self, 2, 4)
        ]);
        self.currentList = ko.observable(self.lists()[2]);

        self.select = function(version, platform) {
            if (self.currentList().gameVersion !== version || self.currentList().platform !== platform) {
                var lists = self.lists().filter(function(item) {
                    return item.gameVersion === version && item.platform === platform;
                });

                if (lists.length === 1) {
                    self.currentList(lists[0]);
                    self.update();
                }
            }
        };

        self.update = function () {
            if (!self.currentList().loading()) {
                self.loading(false);
            }

            self.masonry.reloadItems();
            self.masonry.layout();
        };

        self.loading(true);
        self.update();
    };
});