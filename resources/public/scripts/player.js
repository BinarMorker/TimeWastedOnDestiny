define(['knockout'], function(ko) {
    return function (data) {
        var self = this;

        self.membershipId = data.membershipId;
        self.membershipType = data.membershipType;
        self.displayName = data.displayName;
        self.timePlayed = ko.observable(data.timePlayed).extend({deferred: true});
        self.gameVersion = data.gameVersion;
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
});