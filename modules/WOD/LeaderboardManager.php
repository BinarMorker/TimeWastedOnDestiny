<?php

namespace Apine\Modules\WOD;

use Apine\Core\Database;
use InvalidArgumentException;

class LeaderboardManager {

    /**
     * @param LeaderboardEntry $player
     * @return bool
     */
    public static function playerExists(LeaderboardEntry $player) {
        if (is_null($player->membershipId) ||
            is_null($player->gameVersion)) {
            throw new InvalidArgumentException("Missing required parameters");
        }

        $database = new Database();
        $result = $database->select("SELECT `membershipId` AS `count` FROM `wod_leaderboard` 
                                    WHERE `membershipId` = '{$player->membershipId}' 
                                    AND `membershipType` = {$player->membershipType} 
                                    AND `gameVersion` = {$player->gameVersion}");

        return count($result) > 0;
    }

    /**
     * @param LeaderboardEntry $player
     */
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
                        WHERE `membershipId` = '{$player->membershipId}' 
                        AND `membershipType` = {$player->membershipType} 
                        AND `gameVersion` = {$player->gameVersion}");
    }

    /**
     * @param LeaderboardEntry $player
     */
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

}