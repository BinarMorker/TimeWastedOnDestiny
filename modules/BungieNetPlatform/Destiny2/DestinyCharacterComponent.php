<?php

namespace Apine\Modules\BungieNetPlatform\Destiny2;

class DestinyCharacterComponent {

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
    public $light;

    /**
     * @var object
     */
    public $stats;

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
    public $raceType;

    /**
     * @var int
     */
    public $classType;

    /**
     * @var int
     */
    public $genderType;

    /**
     * @var string
     */
    public $emblemPath;

    /**
     * @var string
     */
    public $emblemBackgroundPath;

    /**
     * @var int
     */
    public $emblemHash;

    /**
     * @var DestinyProgression
     */
    public $levelProgression;

    /**
     * @var int
     */
    public $baseCharacterLevel;

    /**
     * @var float
     */
    public $percentToNextLevel;

}