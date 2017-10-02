<?php

namespace Apine\Controllers\User;


use Apine\Core\Database;
use Apine\Exception\GenericException;
use Apine\Modules\WOD\ApiResponse;
use Apine\Modules\WOD\LeaderboardEntry;
use Apine\Modules\WOD\Player;
use Apine\Modules\WOD\Request\DatabaseRequestCacher;
use Apine\MVC\APIActionsInterface;
use Apine\MVC\JSONView;
use InvalidArgumentException;

class LeaderboardController implements APIActionsInterface {

    private static function getPlayers($gameVersion, $membershipType, $count, $page) {
        $response = new ApiResponse();
        $offset = ($page - 1) * $count;
        $request = new DatabaseRequestCacher();
        $results = $request->cachedRequest("SELECT * FROM `wod_leaderboard` 
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

        return $players;
    }

    private static function getPlayerCount() {
        $database = new Database();
        $result = $database->select("SELECT COUNT(*) AS `count` FROM `wod_leaderboard`");

        return intval($result[0]['count']);
    }

    public static function playerExists(LeaderboardEntry $player) {
        if (is_null($player->membershipId) ||
            is_null($player->gameVersion)) {
            throw new InvalidArgumentException("Missing required parameters");
        }

        $database = new Database();
        $result = $database->select("SELECT `membershipId` AS `count` FROM `wod_leaderboard` 
                                    WHERE `membershipId` = {$player->membershipId} AND `gameVersion` = {$player->gameVersion}");

        return count($result) > 0;
    }

    public static function updatePlayer(LeaderboardEntry $player) {
        if (is_null($player->membershipId) ||
            is_null($player->gameVersion) ||
            is_null($player->timePlayed) ||
            is_null($player->displayName)) {
            throw new InvalidArgumentException("Missing required parameters");
        }

        $database = new Database();
        $database->exec("UPDATE `wod_leaderboard` 
                        SET `timePlayed` = {$player->timePlayed}, `displayName` = '{$player->displayName}'
                        WHERE `membershipId` = {$player->membershipId} AND `gameVersion` = {$player->gameVersion}");
    }

    public static function newPlayer(LeaderboardEntry $player) {
        if (is_null($player->membershipId) ||
            is_null($player->gameVersion) ||
            is_null($player->timePlayed) ||
            is_null($player->displayName) ||
            is_null($player->membershipType)) {
            throw new InvalidArgumentException("Missing required parameters");
        }

        $database = new Database();
        $database->insert("wod_leaderboard", [
            "membershipId" => $player->membershipId,
            "membershipType" => $player->membershipType,
            "displayName" => $player->displayName,
            "timePlayed" => $player->timePlayed,
            "gameVersion" => $player->gameVersion
        ]);
    }

    public function get($params) {
        $view = new JSONView();

        $players = self::getPlayers($params['gameVersion'], $params['membershipType'], 10, $params['page']);
        $count = self::getPlayerCount();

        $view->set_json_file([
            "Players" => $players,
            "TotalCount" => $count
        ]);
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