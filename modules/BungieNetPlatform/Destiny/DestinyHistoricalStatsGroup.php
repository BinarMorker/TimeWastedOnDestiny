<?php

namespace Apine\Modules\BungieNetPlatform\Destiny;

class DestinyHistoricalStatsGroup {

    /**
     * @var \DateTime
     */
    public $period;

    /**
     * @var DestinyHistoricalStatsActivity
     */
    public $activityDetails;

    /**
     * @var DestinyHistoricalStatsValue[]
     */
    public $values;

}