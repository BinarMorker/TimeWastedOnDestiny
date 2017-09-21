define(['knockout', 'player', 'leaderboardmanager'], function(ko, Player, LeaderboardManager) {
    var Leaderboard = function () {
        var self = this;

        var manager = new LeaderboardManager();

        self.entries = ko.observableArray([]);
        self.loading = ko.observable(true);
        self.message = ko.observable(null);
        self.page = ko.observable(1);
        self.page.subscribe(function(value) {
            self.loading(true);
            manager.GetPage(value, self.count, self.populateEntries);
        });
        self.count = 10;
        self.totalPlayers = ko.observable(0);
        self.visible = ko.observable(false);

        self.previous = function() {
            if (self.page() > 1) {
                self.page(self.page() - 1);
            }
        };

        self.next = function() {
            if (self.page() * self.count < self.totalPlayers()) {
                self.page(self.page() + 1);
            }
        };

        self.load = function (page) {
            self.loading(true);
            manager.GetPage(page, self.count, self.populateEntries);
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
        };

        self.load(1);
    };

    return Leaderboard;
});