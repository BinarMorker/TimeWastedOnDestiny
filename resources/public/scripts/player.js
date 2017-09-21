define(['knockout'], function(ko) {
    var Player = function (data) {
        var self = this;

        self.membershipId = data.id;
        self.membershipType = data.console;
        self.displayName = data.username;
        self.timePlayed = ko.observable(data.seconds).extend({deferred: true});
        self.iconPath = null;

        switch (self.membershipType) {
            case 1:
                self.iconPath = '/resources/public/assets/XboxLiveLogo.png';
                break;
            case 2:
                self.iconPath = '/resources/public/assets/PSNLogo.png';
                break;
            case 4:
                self.iconPath = '/resources/public/assets/BattlenetLogo.png';
                break;
        }
    };

    return Player;
});