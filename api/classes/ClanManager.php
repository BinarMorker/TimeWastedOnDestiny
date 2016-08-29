<?php

/**
 * Manage Destiny clans and get relevant information
 * @author François Allard <binarmorker@gmail.com>
 * @version 2.0.0
 */
class ClanManager {

	/**
	 * All API calls
	 * @var array
	 */
	private $apiQueries = array();

    public function getClanLeaderboard($platformType, $clanId, $page, $debug = false) {
        try {
            $clanMembers = BungieNetPlatform::getClanMembers(
                $platformType, 
                $clanId, 
                $page
            );
            if (Config::get('debug')) $this->apiQueries[] = $clanMembers;
        } catch (Exception $exception) {
            throw ApiException::copy($exception);
        }

        $data['total'] = $clanMembers->totalResults;
        $data['page'] = $page;
        $data['players'] = array_map(function($item) {
            try {
                $uri = new ExternalURIRequest($_SERVER["SERVER_NAME"] . '/api/');
                $uri->addParams(array(
                    'console' => $item->membershipType,
                    'user' => $item->destinyUserInfo->displayName
                ));
                $result = json_decode($uri->query("GET", null));
                $response = $result->Response;
                if (Config::get('debug')) $this->apiQueries[] = $response;
            } catch (ExternalURIRequestException $exception) {
                if (Config::get("debug")) {
                    throw $exception;
                } else {
                    throw new BungieNetPlatformException(
                        'Could not find user.', 
                        404
                    );
                }
            }

            $member = new stdClass();
            $member->membershipType = $item->membershipType;
            $member->membershipId = $item->membershipId;
            $member->displayName = $response->{$item->membershipType==2?'playstation':'xbox'}->displayName;
            $member->timePlayed = $response->{$item->membershipType==2?'playstation':'xbox'}->timePlayed;
            return $member;
        }, $clanMembers->results);

		if (Config::get('debug') && $debug) {
			$data['debug'] = true;
			$data['apiQueries'] = $this->apiQueries;
		}

        return $data;
    }

}