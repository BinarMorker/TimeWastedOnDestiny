define(['knockout'], function(ko) {
    return function (data) {
        var self = this;

        self.characterId = data.characterId;
        self.deleted = data.deleted;
        self.timePlayed = ko.observable(data.timePlayed);
        self.race = data.race;
        self.gender = data.gender;
        self.charClass = data.charClass;
        self.level = data.level;
        self.emblemPath = data.emblemPath;
        self.backgroundPath = data.backgroundPath;
    };
});