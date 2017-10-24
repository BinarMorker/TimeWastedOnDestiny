<?php

namespace Apine\Modules\WOD\Request\Destiny;

use Apine\Modules\BungieNetPlatform\Destiny\GetActivityHistoryForCharacterResponse;
use JsonMapper;

class GetActivityHistoryForCharacterRequest extends BungieNetPlatformRequest {

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
     * @return GetActivityHistoryForCharacterResponse
     */
    public function getResponse() {
        list($this->code, $body) = parent::makeRequest("Stats/ActivityHistory/%s/%s/%s/", "GET", "Destiny", [
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
        $object = $mapper->map($json, new GetActivityHistoryForCharacterResponse());
        /** @var GetActivityHistoryForCharacterResponse $object */
        return $object;
    }

}