<?php

namespace Apine\Controllers\User;


use Apine\Core\Database;
use Apine\Exception\GenericException;
use Apine\Modules\WOD\Player;
use Apine\MVC\APIActionsInterface;
use Apine\MVC\JSONView;

class LeaderboardController implements APIActionsInterface {

    private static function GetPlayers($count, $page) {
        $database = new Database();
        $offset = ($page - 1) * $count;
        $results = $database->select("SELECT * FROM `wod_leaderboard` ORDER BY `seconds` DESC LIMIT $count OFFSET $offset");
        $players = [];

        /*foreach ($results as $result) {
            $player = new Player();
            $player->setId($result['id']);
            $player->setConsole(intval($result['console']) == 0 ? 1 : 2);
            $player->setUsername($result['username']);
            $player->setSeconds($result['seconds']);
            $players[] = $player;
        }*/

        return $players;
    }

    private static function GetPlayerCount() {
        $database = new Database();
        $result = $database->select("SELECT COUNT(*) AS `count` FROM `wod_leaderboard`");

        return intval($result[0]['count']);
    }

    public function get($params) {
        $view = new JSONView();

        $players = self::GetPlayers($params['count'], $params['page']);
        $count = self::GetPlayerCount();

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