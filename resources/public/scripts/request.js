define(function() {
    return function (url, data, success, error, always) {
        try {
            var request = new XMLHttpRequest();
            var method = 'GET';
            var query = [];
            Object.entries(data).forEach(function(keyValuePair) {
                query.push(keyValuePair.join('='));
            });
            var queryString = query.join('&');

            if (queryString !== "") {
                url += '?' + queryString;
            }

            request.open(method, url, true);

            request.onload = function() {
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

            request.onerror = function() {
                if (error) {
                    error(JSON.parse(request.response));
                }

                if (always) {
                    always(JSON.parse(request.response));
                }
            };

            request.send();
        } catch(e) {
            throw e;
        }
    };
});