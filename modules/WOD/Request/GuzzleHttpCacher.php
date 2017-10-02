<?php

namespace Apine\Modules\WOD\Request;

use Apine\Application\Application;
use Apine\Modules\BungieNetPlatform\Destiny\BungieNetPlatformResponse;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use JsonMapper;

class GuzzleHttpCacher {

    protected $cacheTime;

    private $cacheHash;

    private $url;

    private $method;

    private $modifiedDate;

    private $inCache;

    private $expiration;

    private $contents;

    protected function cachedRequest($method, $url, $headers) {
        $this->method = $method;
        $this->url = $url;
        $this->cacheHash = md5($method . $url);
        $cacheDirPath = Application::get_instance()->include_path() . '/cache';
        $cacheFilePath = $cacheDirPath . '/' . $this->cacheHash;

        if (!is_dir($cacheDirPath)) {
            mkdir($cacheDirPath);
        }

        $this->modifiedDate = new DateTime();
        $this->expiration = new DateTime();
        $now = new DateTime();

        if (is_file($cacheFilePath)) {
            $this->modifiedDate->setTimestamp(filemtime($cacheFilePath));
            $this->expiration->setTimestamp(filemtime($cacheFilePath) + $this->cacheTime);

            if ($this->expiration > $now) {
                $this->inCache = true;
                $body = file_get_contents($cacheFilePath);
                $this->contents = json_decode($body);
                return [200, $body, $this->modifiedDate];
            }
        }

        $this->inCache = false;
        $client = new Client();
        $request = new Request($method, $url, $headers);
        $response = $client->send($request);

        $code = $response->getStatusCode();

        if ($code < 200 || $code >= 400) {
            throw new Exception("Invalid web response", $code);
        }

        $body = $response->getBody()->getContents();
        $this->contents = json_decode($body);
        $mapper = new JsonMapper();
        /** @var BungieNetPlatformResponse $object */
        $object = $mapper->map($this->contents, new BungieNetPlatformResponse());

        if ($object->errorCode == 1) {
            file_put_contents($cacheFilePath, $body);
        }

        return [ $code, $body, $now ];
    }

    public function getInfo() {
        return [
            "id" => $this->cacheHash,
            "endpoint" => $this->url,
            "method" => $this->method,
            "inCache" => $this->inCache,
            "cacheTime" => $this->modifiedDate,
            "contents" => $this->contents,
            "expiration" => $this->expiration
        ];
    }

}