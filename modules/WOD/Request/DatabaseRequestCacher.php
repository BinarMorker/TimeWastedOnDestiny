<?php

namespace Apine\Modules\WOD\Request;

use Apine\Application\Application;
use Apine\Core\Database;
use Apine\Modules\BungieNetPlatform\Destiny\BungieNetPlatformResponse;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use JsonMapper;

class DatabaseRequestCacher {

    protected $cacheTime;

    private $cacheHash;

    private $sql;

    private $modifiedDate;

    private $inCache;

    private $expiration;

    private $contents;

    public function cachedRequest($sql) {
        $this->sql = $sql;
        $this->cacheHash = md5($sql);
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
                return [ $body, $this->modifiedDate ];
            }
        }

        $this->inCache = false;
        $database = new Database();
        $this->contents = $database->select($sql);

        file_put_contents($cacheFilePath, json_encode($this->contents));

        return [ $this->contents, $now ];
    }

    public function getInfo() {
        return [
            "id" => $this->cacheHash,
            "request" => $this->sql,
            "inCache" => $this->inCache,
            "cacheTime" => $this->modifiedDate,
            "contents" => $this->contents,
            "expiration" => $this->expiration
        ];
    }

}