<?php

namespace Apine\Modules\BungieNetPlatform\Destiny2;

class DestinyHistoricalStatsAccountResult {

    /**
     * @var DestinyHistoricalStatsWithMerged
     */
    public $mergedDeletedCharacters;

    /**
     * @var DestinyHistoricalStatsWithMerged
     */
    public $mergedAllCharacters;

    /**
     * @var DestinyHistoricalStatsPerCharacter[]
     */
    public $characters;

}