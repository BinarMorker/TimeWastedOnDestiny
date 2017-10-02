<?php

namespace Apine\Modules\BungieNetPlatform\Destiny2;

class DestinyProfileComponent {

    /**
     * @var UserInfoCard
     */
    public $userInfo;

    /**
     * @var \DateTime
     */
    public $dateLastPlayed;

    /**
     * @var int
     */
    public $versionsOwned;

    /**
     * @var string[]
     */
    public $characterIds;

}