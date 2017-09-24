define(['request'], function(Request) {
    var LeaderboardManager = function () {
        var self = this;

        self.GetPage = function (page, count, success, error, always) {
            /*Request('/api/leaderboard', {
                count: count,
                page: page
            }, success, error, always);*/
        };
    };

    return LeaderboardManager;
});