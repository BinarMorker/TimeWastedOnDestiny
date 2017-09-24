<?php

namespace Apine\Modules\BungieNetPlatform\Destiny2;

class DestinyProfileResponse {

    /**
     * @var SingleComponentResponseOfDestinyProfileComponent
     */
    public $profile;

    /**
     * @var DictionaryComponentResponseOfint64AndDestinyCharacterComponent
     */
    public $characters;

    /**
     * @var string[]
     */
    public $itemComponents;

}