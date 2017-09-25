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
        $this->cacheTime = 14400; // 4 hours
    }

    /**
     * @return GetHistoricalStatsForAccountResponse
     */
    public function getResponse() {
        list($this->code, $body) = parent::makeRequest("Stats/Account/%s/%s", "GET", "Destiny", [
            $this->membershipType,
            $this->membershipId
        ]);

        $json = json_decode($body);
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetHistoricalStatsForAccountResponse());
        /** @var GetHistoricalStatsForAccountResponse $object */
        return $object;
    }

}