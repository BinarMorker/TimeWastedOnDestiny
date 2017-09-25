<?php

namespace Apine\Modules\WOD\Request\Destiny2;

use Apine\Modules\BungieNetPlatform\Destiny2\SearchDestinyPlayerResponse;
use JsonMapper;

class SearchDestinyPlayerRequest extends BungieNetPlatformRequest {

    /**
     * @var int
     */
    private $membershipType;

    /**
     * @var string
     */
    private $displayName;

    public function __construct($membershipType, $displayName) {
        $this->membershipType = $membershipType;
        $this->displayName = $displayName;
        $this->cacheTime = 14400; // 4 hours
    }

    /**
     * @return SearchDestinyPlayerResponse
     */
    public function getResponse() {
        list($this->code, $body) = parent::makeRequest("SearchDestinyPlayer/%s/%s", "GET", "Destiny2", [
            $this->membershipType,
            $this->displayName
        ]);

        $json = json_decode($body);
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new SearchDestinyPlayerResponse());
        /** @var SearchDestinyPlayerResponse $object */
        return $object;
    }

}