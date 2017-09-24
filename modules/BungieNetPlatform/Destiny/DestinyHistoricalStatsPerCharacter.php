<?php

namespace Apine\Modules\BungieNetPlatform\Destiny;

class DestinyHistoricalStatsPerCharacter {

    /**
     * @var string
     */
    public $characterId;

    /**
     * @var bool
     */
    public $deleted;

    /**
     * @var DestinyHistoricalStatsByPeriod[]
     */
    public $results;

    /**
     * @var DestinyHistoricalStatsByPeriod
     */
    public $merged;

}