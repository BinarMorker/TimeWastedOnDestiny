define(['request'], function(Request) {
    return function () {
        var self = this;

        self.GetPage = function (gameVersion, membershipType, page, success, error, always) {
            Request('/api/leaderboard', {
                gameVersion: gameVersion,
                membershipType: membershipType,
                page: page
            }, success, error, always);
        };
    };
});