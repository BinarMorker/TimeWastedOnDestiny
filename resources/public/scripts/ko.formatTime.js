define(['knockout'], function(ko) {
    ko.bindingHandlers.formatTime = {
        init: function (element, valueAccessor) {
            var hoursMode = ko.dataFor(document.body).hoursMode;

            hoursMode.subscribe(function () {
                valueAccessor().valueHasMutated();
            });
        },
        update: function (element, valueAccessor) {
            var value = ko.unwrap(valueAccessor());
            var hoursMode = ko.dataFor(document.body).hoursMode;
            var seconds = Number(value);

            if (seconds) {
                if (hoursMode()) {
                    value = Math.floor(seconds / (60 * 60)) + 'h';
                } else {
                    var years = Math.floor(seconds / (60 * 60 * 24 * 365));
                    var weeks = Math.floor(seconds / (60 * 60 * 24 * 7)) % 52;
                    var days = Math.floor(seconds / (60 * 60 * 24)) % 7;
                    var hours = Math.floor(seconds / (60 * 60)) % 24;
                    var minutes = Math.floor(seconds / 60) % 60;
                    seconds = seconds % 60;

                    value = (years ? (years + 'y ') : '') +
                        (weeks ? (weeks + 'w ') : '') +
                        (days ? (days + 'd ') : '') +
                        (hours ? (hours + 'h ') : '') +
                        (minutes ? (minutes + 'm ') : '') +
                        (seconds ? (seconds + 's') : '');
                }
            }

            $(element).text(value);
        }
    };
});