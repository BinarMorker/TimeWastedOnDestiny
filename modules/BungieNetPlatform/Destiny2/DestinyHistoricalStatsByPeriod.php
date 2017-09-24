<?php

namespace Apine\Modules\BungieNetPlatform\Destiny2;

class DestinyHistoricalStatsByPeriod {

    /**
     * @var DestinyHistoricalStatsValue[]
     */
    public $allTime;

    /**
     * @var DestinyHistoricalStatsValue[]
     */
    public $allTimeTier1;

    /**
     * @var DestinyHistoricalStatsValue[]
     */
    public $allTimeTier2;

    /**
     * @var DestinyHistoricalStatsValue[]
     */
    public $allTimeTier3;

    /**
     * @var DestinyHistoricalStatsPeriodGroup[]
     */
    public $daily;

    /**
     * @var DestinyHistoricalStatsPeriodGroup[]
     */
    public $monthly;

}