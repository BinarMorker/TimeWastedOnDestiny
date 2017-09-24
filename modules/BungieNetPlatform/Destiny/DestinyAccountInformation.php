<?php

namespace Apine\Modules\BungieNetPlatform\Destiny;

class DestinyAccountInformation {

    /**
     * @var string
     */
    public $membershipId;

    /**
     * @var int
     */
    public $membershipType;

    /**
     * @var DestinyCharacter[]
     */
    public $characters;

    /**
     * @var object
     */
    public $inventory;

    /**
     * @var int
     */
    public $grimoireScore;

    /**
     * @var object
     */
    public $vendorReceipts;

    /**
     * @var \DateTime
     */
    public $dateLastPlayed;

    /**
     * @var int
     */
    public $versions;

}