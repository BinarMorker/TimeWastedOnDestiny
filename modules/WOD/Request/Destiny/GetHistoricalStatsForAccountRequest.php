<?php

namespace Apine\Modules\WOD\Request\Destiny;

use Apine\Modules\BungieNetPlatform\Destiny\GetHistoricalStatsForAccountResponse;
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
        $response = parent::makeRequest("Stats/Account/%s/%s", "GET", "Destiny", [
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