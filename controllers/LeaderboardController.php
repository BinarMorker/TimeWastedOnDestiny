<?php

namespace Apine\Controllers\User;


use Apine\Application\Application;
use Apine\Exception\GenericException;
use Apine\Modules\WOD\ApiResponse;
use Apine\Modules\WOD\LeaderboardEntry;
use Apine\Modules\WOD\LeaderboardResponse;
use Apine\Modules\WOD\Request\DatabaseRequestCacher;
use Apine\MVC\APIActionsInterface;
use Apine\MVC\JSONView;
use DateTime;
use Exception;

class LeaderboardController implements APIActionsInterface {

    /**
     * @param $gameVersion
     * @param $membershipType
     * @param $count
     * @param $page
     * @return array
     */
    private static function getPlayers($gameVersion, $membershipType, $count, $page) {
        $offset = ($page - 1) * $count;
        $request = new DatabaseRequestCacher();
        $request->cacheTime = 14400;
        list($results) = $request->cachedRequest("SELECT * FROM `wod_leaderboard` 
                                           WHERE `gameVersion` = $gameVersion 
                                           AND `membershipType` = $membershipType 
                                           ORDER BY `timePlayed` DESC 
                                           LIMIT $count OFFSET $offset");
        $players = [];

        foreach ($results as $result) {
            $player = new LeaderboardEntry();
            $player->membershipId = $result['membershipId'];
            $player->membershipType = $result['membershipType'];
            $player->displayName = $result['displayName'];
            $player->timePlayed = $result['timePlayed'];
            $player->gameVersion = $result['gameVersion'];
            $players[] = $player;
        }

        return [ $players, $request->getInfo() ];
    }

    /**
     * @return array
     */
    private static function getPlayerCount() {
        $request = new DatabaseRequestCacher();
        $request->cacheTime = 14400;
        list($results) = $request->cachedRequest("SELECT COUNT(*) AS `count` FROM `wod_leaderboard`");

        return [ intval($results[0]['count']), $request->getInfo() ];
    }

    /**
     * @param $params
     * @param $response
     */
    private function debug($params, &$response) {
        if (!isset($params['debug']) || Application::get_instance()->get_mode() != APINE_MODE_DEVELOPMENT) {
            unset($response->endpointCalls);
        } else {
            if (!isset($params['verbose'])) {
                foreach ($response->endpointCalls as $index => $endpointCall) {
                    unset($response->endpointCalls[$index]['contents']);
                }
            }
        }
    }

    /**
     * Fetch leaderboard pages
     * @link /api/leaderboard?membershipType=[]&gameVersion=[]&page=[]
     *
     * @param $params
     * @return JSONView
     */
    public function get($params) {
        $start = microtime(true);
        $now = new DateTime();
        $response = new ApiResponse();
        $response->queryTime = $now;
        $response->endpointCalls = [];
        $view = new JSONView();
        $response->code = 1;
        $response->response = new LeaderboardResponse();
        $response->response->count = 10;
        $response->response->page = intval($params['page']);

        try {
            list($response->response->players, $endpoint) = self::getPlayers($params['gameVersion'], $params['membershipType'], 10, intval($params['page']));
            $response->endpointCalls[] = $endpoint;
            list($response->response->totalPlayers, $endpoint) = self::getPlayerCount();
            $response->endpointCalls[] = $endpoint;
        } catch (Exception $e) {
            $response->code = $e->getCode();
            $response->message = $e->getMessage();
        }

        $this->debug($params, $response);
        $response->executionMilliseconds = (microtime(true) - $start) * 1000;
        $view->set_json_file($response);
        return $view;
    }

    public function post($params) {
        throw new GenericException('Forbidden', 403);
    }

    public function put($params) {
        throw new GenericException('Forbidden', 403);
    }

    public function delete($params) {
        throw new GenericException('Forbidden', 403);
    }
}