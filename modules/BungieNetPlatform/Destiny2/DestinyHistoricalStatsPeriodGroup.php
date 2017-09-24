<?php

namespace Apine\Modules\BungieNetPlatform\Destiny2;

class DestinyHistoricalStatsPeriodGroup {

    /**
     * @var \DateTime
     */
    public $period;

    /**
     * @var DestinyHistoricalStatsActivity
     */
    public $activityDetails;

    /**
     * @var DestinyHistoricalStatsValue
     */
    public $values;

}