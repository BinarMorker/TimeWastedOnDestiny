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
    }

    /**
     * @return SearchDestinyPlayerResponse
     */
    public function getResponse() {
        $response = parent::makeRequest("SearchDestinyPlayer/%s/%s", "GET", "Destiny2", [
            $this->membershipType,
            $this->displayName
        ]);

        $this->code = $response->getStatusCode();
        $json = json_decode($response->getBody()->getContents());
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new SearchDestinyPlayerResponse());
        /** @var SearchDestinyPlayerResponse $object */
        return $object;
    }

}