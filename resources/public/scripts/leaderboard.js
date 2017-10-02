define(['knockout', 'player', 'leaderboardmanager'], function(ko, Player, LeaderboardManager) {
    return function Leaderboard(masonry) {
        var self = this;

        var manager = new LeaderboardManager();

        self.masonry = masonry;
        self.entries = ko.observableArray([]);
        self.loading = ko.observable(true);
        self.message = ko.observable(null);
        self.page = ko.observable(1);
        self.totalPlayers = ko.observable(0);
        self.visible = ko.observable(false);
        self.gameVersion = ko.observable(2);
        self.platform = ko.observable(2);

        self.selectVersion = function(version) {
            if (self.gameVersion() !== version) {
                self.gameVersion(version);
                self.page(1);
                self.load();
            }
        };

        self.selectPlatform = function(platform) {
            if (self.platform() !== platform) {
                self.platform(platform);
                self.page(1);
                self.load();
            }
        };

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
            manager.GetPage(self.gameVersion(), self.platform(), self.page(), self.populateEntries);
        };

        self.populateEntries = function (data) {
            self.entries([]);

            if (data.Players && data.Players.length > 0) {
                data.Players.forEach(function (item) {
                    self.entries.push(new Player(item));
                });
            }

            self.totalPlayers(data.TotalCount);
            self.loading(false);
            self.masonry.reloadItems();
            self.masonry.layout();
        };

        self.loading(true);
        self.load();
    };
});