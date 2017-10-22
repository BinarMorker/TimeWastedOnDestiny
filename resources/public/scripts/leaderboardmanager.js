define(['request'], function(Request) {
    return function () {
        var self = this;
        var pages = {};

        self.GetPage = function (gameVersion, membershipType, page, success, error, always) {
            var key = 'g=' + gameVersion + '_t=' + membershipType + '_p=' + page;

            if (pages[key]) {
                success(pages[key]);
                always(true);
            } else {
                Request('/api/leaderboard', {
                    gameVersion: gameVersion,
                    membershipType: membershipType,
                    page: page
                }, function (result) {
                    pages[key] = result;
                    success(result);
                }, error, always);
            }
        };
    };
});