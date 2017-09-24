<?php

namespace Apine\Modules\BungieNetPlatform\Destiny2;

class DestinyHistoricalStatsValue {

    /**
     * @var string
     */
    public $statId;

    /**
     * @var DestinyHistoricalStatsValuePair
     */
    public $basic;

    /**
     * @var DestinyHistoricalStatsValuePair
     */
    public $pga;

    /**
     * @var DestinyHistoricalStatsValuePair
     */
    public $weighted;

}