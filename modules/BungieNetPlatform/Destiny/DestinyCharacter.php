<?php

namespace Apine\Modules\BungieNetPlatform\Destiny;

class DestinyCharacter {

    /**
     * @var DestinyCharacterBase
     */
    public $characterBase;

    /**
     * @var DestinyProgression
     */
    public $levelProgression;

    /**
     * @var string
     */
    public $emblemPath;

    /**
     * @var string
     */
    public $backgroundPath;

    /**
     * @var int
     */
    public $emblemHash;

    /**
     * @var int
     */
    public $characterLevel;

    /**
     * @var int
     */
    public $baseCharacterLevel;

    /**
     * @var bool
     */
    public $isPrestigeLevel;

    /**
     * @var int
     */
    public $percentToNextLevel;

}