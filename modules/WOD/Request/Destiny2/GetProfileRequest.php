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
    }

    /**
     * @return GetProfileResponse
     */
    public function getResponse() {
        $response = parent::makeRequest("%s/Profile/%s", "GET", "Destiny2", [
            $this->membershipType,
            $this->membershipId
        ], [
            'components' => join(',', $this->components)
        ]);

        $this->code = $response->getStatusCode();
        $json = json_decode($response->getBody()->getContents());
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetProfileResponse());
        /** @var GetProfileResponse $object */
        return $object;
    }

}