define(function() {
    return function (url, data, success, error, always) {
        try {
            var request = new XMLHttpRequest();
            var method = 'POST';
            request.open(method, url, true);
            request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');

            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    if (success) {
                        success(JSON.parse(request.response));
                    }
                } else {
                    if (error) {
                        error(JSON.parse(request.response));
                    }
                }

                if (always) {
                    always(JSON.parse(request.response));
                }
            };

            request.onerror = function () {
                if (error) {
                    error(JSON.parse(request.response));
                }

                if (always) {
                    always(JSON.parse(request.response));
                }
            };

            request.send(JSON.stringify(data));
        } catch (e) {
            throw e;
        }
    };
});