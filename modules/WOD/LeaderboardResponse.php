<?php

namespace Apine\Modules\WOD;

class LeaderboardResponse {

    /**
     * @var LeaderboardEntry[]
     */
    public $players;

    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $count;

    /**
     * @var int
     */
    public $totalPlayers;

}