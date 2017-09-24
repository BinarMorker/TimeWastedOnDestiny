<?php

namespace Apine\Modules\BungieNetPlatform\Destiny;

class DestinyCharacterBase {

    /**
     * @var string
     */
    public $membershipId;

    /**
     * @var int
     */
    public $membershipType;

    /**
     * @var string
     */
    public $characterId;

    /**
     * @var \DateTime
     */
    public $dateLastPlayed;

    /**
     * @var int
     */
    public $minutesPlayedThisSession;

    /**
     * @var int
     */
    public $minutesPlayedTotal;

    /**
     * @var int
     */
    public $powerLevel;

    /**
     * @var int
     */
    public $raceHash;

    /**
     * @var int
     */
    public $genderHash;

    /**
     * @var int
     */
    public $classHash;

    /**
     * @var int
     */
    public $currentActivityHash;

    /**
     * @var int
     */
    public $lastCompletedStoryHash;

    /**
     * @var object
     */
    public $stats;

    /**
     * @var object
     */
    public $customization;

    /**
     * @var int
     */
    public $grimoireScore;

    /**
     * @var object
     */
    public $peerView;

    /**
     * @var int
     */
    public $genderType;

    /**
     * @var int
     */
    public $classType;

    /**
     * @var object
     */
    public $buildStatGroupHash;

}