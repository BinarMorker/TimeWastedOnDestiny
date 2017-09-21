<?php

namespace Apine\Controllers\User;

use Apine\Application\Config;
use Apine\Exception\GenericException;
use Apine\MVC\Controller;
use Apine\MVC\JSONView;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use SQLite3;
use ZipArchive;

class BungieController extends Controller {

    const BASEPATH = "https://www.bungie.net/Platform";
    const BASED1PATH = "https://www.bungie.net/d1/Platform";
    const BUNGIENET = "https://www.bungie.net";

    private static function getDefinition(SQLite3 $db, $tables, &$definitions, $bungieName, $localName) {
        if (isset($tables[$bungieName])) {
            $result = $db->query("SELECT `id`, `json` FROM $bungieName");

            $definitions[$localName] = [];

            while($row = $result->fetchArray()) {
                $key = is_numeric($row['id']) ? sprintf('%u', $row['id'] & 0xFFFFFFFF) : $row['id'];
                $definitions[$localName][$key] = json_decode($row['json'], true);
            }
        }
    }

    public static function fetchDefinitions($params) {
        //throw new GenericException('Forbidden', 403); // Private

        $view = new JSONView();
        $apiKey = Config::get('wod', 'api_key');
        $version = isset($params['version']) ? $params['version'] : 2;
        $headers = [
            'X-API-Key' => $apiKey
        ];

        if ($params['gameVersion'] == 1) {
            $url = join('/', [$version == "2" ? self::BASEPATH : self::BASED1PATH, "Destiny/Manifest"]);
        } else {
            $url = join('/', [$version == "2" ? self::BASEPATH : self::BASED1PATH, "Destiny2/Manifest"]);
        }

        $client = new Client();
        $request = new Request('GET', $url, $headers);
        $response = $client->send($request);
        $content = json_decode($response->getBody()->getContents(), true);
        $manifestFile = $content['Response']['mobileWorldContentPaths']['en'];
        $manifestFilePath = 'manifests/' . pathinfo($manifestFile, PATHINFO_BASENAME);

        if (!file_exists(dirname($manifestFilePath))) {
            mkdir(dirname($manifestFilePath), 0777, true);
        }

        $request = new Request('GET', self::BUNGIENET . $manifestFile, $headers);
        $response = $client->send($request);
        $view->set_response_code($response->getStatusCode());
        file_put_contents($manifestFilePath.'.zip', $response->getBody());
        $zip = new ZipArchive();

        if ($zip->open($manifestFilePath.'.zip') === TRUE) {
            $zip->extractTo('manifests');
            $zip->close();
            unlink($manifestFilePath.'.zip');
        }

        $definitions = [];

        if ($db = new SQLite3($manifestFilePath)) {
            $tables = [];
            $result = $db->query("SELECT `name` FROM sqlite_master WHERE type='table'");

            while($row = $result->fetchArray()) {
                $table = [];
                $result2 = $db->query("PRAGMA table_info(".$row['name'].")");

                while($row2 = $result2->fetchArray()) {
                    $table[] = $row2[1];
                }

                $tables[$row['name']] = $table;
            }

            self::getDefinition($db, $tables, $definitions, 'DestinyClassDefinition', 'Classes');
            self::getDefinition($db, $tables, $definitions, 'DestinyGenderDefinition', 'Genders');
            self::getDefinition($db, $tables, $definitions, 'DestinyRaceDefinition', 'Races');
        }

        $cacheFilePath = 'manifests/' . pathinfo("manifest_D$version.json", PATHINFO_BASENAME);
        file_put_contents($cacheFilePath, json_encode($definitions));

        $view->set_json_file($definitions);

        return $view;
    }

    public static function bungieProxy($params) {
        throw new GenericException('Forbidden', 403); // Private

        $view = new JSONView();

        $response = self::request($params['uri'], $params['method'], $params['service'], $params['version'], isset($params['params']) ? $params['params'] : [], isset($params['query']) ? $params['query'] : [], isset($params['headers']) ? $params['headers'] : []);

        $view->set_response_code($response->getStatusCode());
        $content = json_decode($response->getBody()->getContents(), true);
        $view->set_json_file($content);

        return $view;
    }

    public function fetchAccount($params) {
        $view = new JSONView();

        try {
            $response = self::request("GetMembershipsById/%s/%s", "GET", "User", 2, [
                $params['membershipId'],
                $params['membershipType']
            ]);

            $view->set_response_code($response->getStatusCode());
            $allAccounts = json_decode($response->getBody()->getContents(), true);
            $view->set_json_file($allAccounts);

            if (isset($allAccounts['Response']['destinyMemberships'])) {
                $memberships = $allAccounts['Response']['destinyMemberships'];
                $allAccounts['Response']['destinyMemberships'] = [];

                $xblAccount = array_values(array_filter($memberships, function($data) {
                    return $data['membershipType'] == 1;
                }));

                if (count($xblAccount) > 0) {
                    $xblAccount[0]['gameVersion'] = 1;
                    $allAccounts['Response']['destinyMemberships'][] = $xblAccount[0];
                    $xblAccount[0]['gameVersion'] = 2;
                    $allAccounts['Response']['destinyMemberships'][] = $xblAccount[0];
                }

                $psnAccount = array_values(array_filter($memberships, function($data) {
                    return $data['membershipType'] == 2;
                }));

                if (count($psnAccount) > 0) {
                    $psnAccount[0]['gameVersion'] = 1;
                    $allAccounts['Response']['destinyMemberships'][] = $psnAccount[0];
                    $psnAccount[0]['gameVersion'] = 2;
                    $allAccounts['Response']['destinyMemberships'][] = $psnAccount[0];
                }

                $bliAccount = array_values(array_filter($memberships, function($data) {
                    return $data['membershipType'] == 4;
                }));

                if (count($bliAccount) > 0) {
                    $bliAccount[0]['gameVersion'] = 2;
                    $allAccounts['Response']['destinyMemberships'][] = $bliAccount[0];
                }

                $view->set_json_file($allAccounts);
                return $view;
            }
        } catch (Exception $e) {
        }

        $view->set_response_code(400);
        return $view;
    }

    public function fetchAccounts($params) {
        $view = new JSONView();

        try {
            $response = self::request("SearchDestinyPlayer/%s/%s", "GET", "Destiny", 2, [
                $params['membershipType'],
                $params['displayName']
            ]);

            $view->set_response_code($response->getStatusCode());
            $foundPlayers = json_decode($response->getBody()->getContents(), true);

            foreach ($foundPlayers['Response'] as $foundPlayer) {
                try {
                    $response = self::request("GetMembershipsById/%s/%s", "GET", "User", 2, [
                        $foundPlayer['membershipId'],
                        $foundPlayer['membershipType']
                    ]);

                    $view->set_response_code($response->getStatusCode());
                    $allAccounts = json_decode($response->getBody()->getContents(), true);
                    $view->set_json_file($allAccounts);

                    if (isset($allAccounts['Response']['destinyMemberships'])) {
                        $memberships = $allAccounts['Response']['destinyMemberships'];
                        $allAccounts['Response']['destinyMemberships'] = [];

                        $xblAccount = array_values(array_filter($memberships, function($data) {
                            return $data['membershipType'] == 1;
                        }));

                        if (count($xblAccount) > 0) {
                            $xblAccount[0]['gameVersion'] = 1;
                            $allAccounts['Response']['destinyMemberships'][] = $xblAccount[0];
                            $xblAccount[0]['gameVersion'] = 2;
                            $allAccounts['Response']['destinyMemberships'][] = $xblAccount[0];
                        }

                        $psnAccount = array_values(array_filter($memberships, function($data) {
                            return $data['membershipType'] == 2;
                        }));

                        if (count($psnAccount) > 0) {
                            $psnAccount[0]['gameVersion'] = 1;
                            $allAccounts['Response']['destinyMemberships'][] = $psnAccount[0];
                            $psnAccount[0]['gameVersion'] = 2;
                            $allAccounts['Response']['destinyMemberships'][] = $psnAccount[0];
                        }

                        $bliAccount = array_values(array_filter($memberships, function($data) {
                            return $data['membershipType'] == 4;
                        }));

                        if (count($bliAccount) > 0) {
                            $bliAccount[0]['gameVersion'] = 2;
                            $allAccounts['Response']['destinyMemberships'][] = $bliAccount[0];
                        }

                        $view->set_json_file($allAccounts);
                        return $view;
                    }
                } catch (Exception $e) {
                }
            }

            $view->set_json_file($foundPlayers);

            if (isset($foundPlayers['Response']) && !is_array($foundPlayers['Response'])) {
                return $view;
            }
        } catch (Exception $e) {
        }

        $view->set_response_code(400);
        return $view;
    }

    public function fetchStats($params) {
        $view = new JSONView();

        try {
            if ($params['version'] == 1) {
                $response = self::request("Stats/Account/%s/%s", "GET", "Destiny", 2, [
                    $params['membershipType'],
                    $params['membershipId']
                ]);
            } else {
                $response = self::request("%s/Account/%s/Stats", "GET", "Destiny2", 2, [
                    $params['membershipType'],
                    $params['membershipId']
                ]);
            }

            $view->set_response_code($response->getStatusCode());
            $stats = json_decode($response->getBody()->getContents(), true);
            $view->set_json_file($stats);

            if (isset($stats['Response'])) {
                return $view;
            }
        } catch (Exception $e) {
        }

        $view->set_response_code(400);
        return $view;
    }

    public function fetchCharacterStats($params) {
        $view = new JSONView();

        try {
            if ($params['version'] == 1) {
                $response = self::request("Stats/Account/%s/%s", "GET", "Destiny", 2, [
                    $params['membershipType'],
                    $params['membershipId']
                ]);

                $view->set_response_code($response->getStatusCode());
                $stats = json_decode($response->getBody()->getContents(), true);
                $view->set_json_file($stats);
            } else {
                $characters = self::request("%s/Profile/%s", "GET", "Destiny2", 2, [
                    $params['membershipType'],
                    $params['membershipId']
                ], [
                    "components" => 200
                ]);

                $view->set_response_code($characters->getStatusCode());
                $charactersStats = json_decode($characters->getBody()->getContents(), true);

                if (isset($charactersStats['Response'])) {
                    $overallStats = $charactersStats;
                    $overallStats["Response"] = [
                        "stats" => []
                    ];

                    foreach ($charactersStats['Response']['characters']['data'] as $character) {
                        $characterStats = self::request("%s/Account/%s/Character/{%s}/Stats", "GET", "Destiny2", 2, [
                            $params['membershipType'],
                            $params['membershipId'],
                            $character['characterId']
                        ]);

                        $view->set_response_code($characterStats->getStatusCode());
                        $stats = json_decode($characterStats->getBody()->getContents(), true);

                        if (isset($stats["Response"])) {
                            $overallStats["Response"]["stats"][] = $stats["Response"];
                        }
                    }

                    $view->set_json_file($overallStats);
                }
            }

            if (isset($stats['Response'])) {
                return $view;
            }
        } catch (Exception $e) {
        }

        $view->set_response_code(400);
        return $view;
    }

    public function fetchCharacters($params) {
        $view = new JSONView();

        try {
            if ($params['gameVersion'] == 1) {
                $response = self::request("%s/Account/%s", "GET", "Destiny", 2, [
                    $params['membershipType'],
                    $params['membershipId']
                ]);
            } else {
                $response = self::request("%s/Profile/%s", "GET", "Destiny2", 2, [
                    $params['membershipType'],
                    $params['membershipId']
                ], [
                    'components' => '100,200'
                ]);
            }

            $view->set_response_code($response->getStatusCode());
            $stats = json_decode($response->getBody()->getContents(), true);
            $view->set_json_file($stats);

            if (isset($stats['Response'])) {
                return $view;
            }
        } catch (Exception $e) {
        }

        $view->set_response_code(400);
        return $view;
    }

    public static function request($a_uri, $a_method, $a_service, $a_version = 1, $a_params = [], $a_query = [], $a_headers = []) {
        if (!isset($a_uri) || !isset($a_method) || !isset($a_service)) {
            throw new GenericException('Bad arguments', 401);
        }

        $uri = $a_uri;
        $method = $a_method;
        $service = $a_service;
        $parameters = isset($a_params) ? $a_params : [];
        $queryString = isset($a_query) ? $a_query : null;
        $additionalHeaders = isset($a_headers) ? $a_headers : null;
        $version = isset($a_version) && $a_version == "2" ? self::BASEPATH : self::BASED1PATH;
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

        $client = new Client();
        $request = new Request($method, $url, $headers);

        try {
            return $client->send($request);
        } catch (ClientException $exception) {
            return $exception->getResponse()->getBody();
        }
    }
}