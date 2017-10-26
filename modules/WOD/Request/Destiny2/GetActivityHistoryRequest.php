<?php

namespace Apine\Modules\WOD\Request\Destiny2;

use Apine\Modules\BungieNetPlatform\Destiny2\GetActivityHistoryResponse;
use Apine\Modules\BungieNetPlatform\Destiny2\GetHistoricalStatsForAccountResponse;
use JsonMapper;

class GetActivityHistoryRequest extends BungieNetPlatformRequest {

    /**
     * @var int
     */
    private $membershipType;

    /**
     * @var string
     */
    private $membershipId;

    /**
     * @var string
     */
    private $characterId;

    /**
     * @var int
     */
    private $page;

    public function __construct($membershipType, $membershipId, $characterId, $page) {
        $this->membershipType = $membershipType;
        $this->membershipId = $membershipId;
        $this->characterId = $characterId;
        $this->page = $page;
        $this->cacheTime = 7200; // 2 hours
    }

    /**
     * @return GetActivityHistoryResponse
     */
    public function getResponse() {
        list($this->code, $body) = parent::makeRequest("%s/Account/%s/Character/%s/Stats/Activities/", "GET", "Destiny2", [
            $this->membershipType,
            $this->membershipId,
            $this->characterId
        ], [
            "mode" => "None",
            "count" => 250,
            "page" => $this->page
        ]);

        $json = json_decode($body);
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetActivityHistoryResponse());
        /** @var GetActivityHistoryResponse $object */
        return $object;
    }

}