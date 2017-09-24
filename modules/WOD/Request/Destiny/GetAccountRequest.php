<?php

namespace Apine\Modules\WOD\Request\Destiny;

use Apine\Modules\BungieNetPlatform\Destiny\GetAccountResponse;
use JsonMapper;

class GetAccountRequest extends BungieNetPlatformRequest {

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
     * @return GetAccountResponse
     */
    public function getResponse() {
        $response = parent::makeRequest("%s/Account/%s", "GET", "Destiny", [
            $this->membershipType,
            $this->membershipId
        ]);

        $this->code = $response->getStatusCode();
        $json = json_decode($response->getBody()->getContents());
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetAccountResponse());
        /** @var GetAccountResponse $object */
        return $object;
    }

}