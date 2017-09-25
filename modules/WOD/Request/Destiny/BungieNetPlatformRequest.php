<?php

namespace Apine\Modules\WOD\Request\Destiny;

use Apine\Application\Config;
use Apine\Modules\BungieNetPlatform\Destiny2\BungieNetPlatformResponse;
use Apine\Modules\WOD\BungieUrlHelper;
use Apine\Modules\WOD\Request\GuzzleHttpCacher;
use InvalidArgumentException;

class BungieNetPlatformRequest extends GuzzleHttpCacher {

    /**
     * @var int
     */
    protected $code;

    /**
     * @return BungieNetPlatformResponse
     */
    public function getResponse() {
        return new BungieNetPlatformResponse();
    }

    /**
     * @return int
     */
    public function getCode() {
        return $this->code;
    }

    protected function makeRequest($a_uri, $a_method, $a_service, $a_params = [], $a_query = [], $a_headers = []) {
        if (!isset($a_uri) || !isset($a_method) || !isset($a_service)) {
            throw new InvalidArgumentException();
        }

        $uri = $a_uri;
        $method = $a_method;
        $service = $a_service;
        $parameters = isset($a_params) ? $a_params : [];
        $queryString = isset($a_query) ? $a_query : null;
        $additionalHeaders = isset($a_headers) ? $a_headers : null;
        $version = BungieUrlHelper::BungieNetPlatformD1;
        $apiKey = Config::get('wod', 'api_key');

        $headers = [];

        if (isset($additionalHeaders) && !empty($additionalHeaders) && is_array($additionalHeaders)) {
            $headers = $additionalHeaders;
        }

        $headers['X-API-Key'] = $apiKey;

        $url = vsprintf(join('/', [$version, $service, $uri]), $parameters);
        $processedQueryString = [];

        if (isset($queryString) && !empty($queryString) && is_array($queryString)) {
            foreach ($queryString as $key => $value) {
                if ($value) {
                    $processedQueryString[] = join('=', [$key, $value]);
                } else {
                    $processedQueryString[] = $key;
                }
            }

            $urlQueryString = join('&', $processedQueryString);
            $url = join('?', [$url, $urlQueryString]);
        }

        return $this->cachedRequest($method, $url, $headers);
    }

}