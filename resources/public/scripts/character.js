define(['knockout'], function(ko) {
    var Character = function (data) {
        var self = this;

        self.characterId = data.characterId;
        self.deleted = data.deleted;
        self.seconds = ko.observable(data.merged.allTime.secondsPlayed.basic.value).extend({deferred: true});
        self.race = "";
        self.gender = "";
        self.charClass = "";
        self.level = 0;
        self.emblemPath = ko.observable(null);
        self.backgroundPath = ko.observable(null);
    };

    return Character;
});