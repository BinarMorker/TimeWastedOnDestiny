<?php

namespace Apine\Modules\BungieNetPlatform\Destiny;

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