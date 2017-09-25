<?php

namespace Apine\Modules\WOD\Request\Destiny2;

use Apine\Modules\BungieNetPlatform\Destiny2\DestinyComponentType;
use Apine\Modules\BungieNetPlatform\Destiny2\GetProfileResponse;
use JsonMapper;

class GetProfileRequest extends BungieNetPlatformRequest {

    /**
     * @var int
     */
    private $membershipType;

    /**
     * @var string
     */
    private $membershipId;

    /**
     * @var int[]
     */
    private $components;

    public function __construct($membershipType, $membershipId, $components) {
        $this->membershipType = $membershipType;
        $this->membershipId = $membershipId;
        $this->components = $components;
        $this->cacheTime = 14400; // 4 hours
    }

    /**
     * @return GetProfileResponse
     */
    public function getResponse() {
        list($this->code, $body) = parent::makeRequest("%s/Profile/%s", "GET", "Destiny2", [
            $this->membershipType,
            $this->membershipId
        ], [
            'components' => join(',', $this->components)
        ]);

        $json = json_decode($body);
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetProfileResponse());
        /** @var GetProfileResponse $object */
        return $object;
    }

}