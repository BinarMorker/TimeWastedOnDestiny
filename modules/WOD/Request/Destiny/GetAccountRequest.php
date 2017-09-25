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
        $this->cacheTime = 14400; // 4 hours
    }

    /**
     * @return GetAccountResponse
     */
    public function getResponse() {
        list($this->code, $body) = parent::makeRequest("%s/Account/%s", "GET", "Destiny", [
            $this->membershipType,
            $this->membershipId
        ]);

        $json = json_decode($body);
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetAccountResponse());
        /** @var GetAccountResponse $object */
        return $object;
    }

}