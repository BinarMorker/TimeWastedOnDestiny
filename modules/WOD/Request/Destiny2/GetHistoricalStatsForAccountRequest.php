<?php

namespace Apine\Modules\WOD\Request\Destiny2;

use Apine\Modules\BungieNetPlatform\Destiny2\GetHistoricalStatsForAccountResponse;
use JsonMapper;

class GetHistoricalStatsForAccountRequest extends BungieNetPlatformRequest {

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
     * @return GetHistoricalStatsForAccountResponse
     */
    public function getResponse() {
        $response = parent::makeRequest("%s/Account/%s/Stats", "GET", "Destiny2", [
            $this->membershipType,
            $this->membershipId
        ]);

        $this->code = $response->getStatusCode();
        $json = json_decode($response->getBody()->getContents());
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetHistoricalStatsForAccountResponse());
        /** @var GetHistoricalStatsForAccountResponse $object */
        return $object;
    }

}