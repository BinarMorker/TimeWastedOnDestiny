define(['knockout'], function(ko) {
    var Account = function (data) {
        var self = this;

        self.membershipId = data.membershipId;
        self.membershipType = data.membershipType;
        self.displayName = data.displayName;
        self.iconPath = null;

        self.bungieNetMembershipId = ko.observable();
        self.bungieNetDisplayName = ko.observable();

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

        self.gameVersion = data.gameVersion;
        self.characters = ko.observableArray([]);
        self.timePlayed = ko.observable(0).extend({deferred: true});
        self.timeWasted = ko.observable(0).extend({deferred: true});
        self.lastPlayed = data.dateLastPlayed.date;
        self.formattedLastPlayed = (new Date(data.dateLastPlayed.date)).toLocaleDateString();
        self.loading = ko.observable(true);
        self.message = ko.observable(null);
        self.visible = ko.observable(false);
    };

    return Account;
});