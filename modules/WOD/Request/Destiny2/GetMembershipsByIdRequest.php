<?php

namespace Apine\Modules\WOD\Request\Destiny2;

use Apine\Modules\BungieNetPlatform\Destiny2\GetMembershipsByIdResponse;
use JsonMapper;

class GetMembershipsByIdRequest extends BungieNetPlatformRequest {

    /**
     * @var int
     */
    private $membershipType;

    /**
     * @var string
     */
    private $membershipId;

    public function __construct($membershipType, $membershipId) {
        $this->membershipType = $membershipType;
        $this->membershipId = $membershipId;
    }

    /**
     * @return GetMembershipsByIdResponse
     */
    public function getResponse() {
        $response = parent::makeRequest("GetMembershipsById/%s/%s", "GET", "User", [
            $this->membershipId,
            $this->membershipType
        ]);

        $this->code = $response->getStatusCode();
        $json = json_decode($response->getBody()->getContents());
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetMembershipsByIdResponse());
        /** @var GetMembershipsByIdResponse $object */
        return $object;
    }

}