<?php

/**
 * Manage Destiny clans and get relevant information
 * @author François Allard <binarmorker@gmail.com>
 * @version 2.1.0
 */
class ClanManager {

	/**
	 * All API calls
	 * @var array
	 */
	private $apiQueries = array();

    public function getClanLeaderboard($clanId, $page, $debug = false) {
        try {
            $clanDetails = BungieNetPlatform::getClanDetails(
                $clanId
            );
            if (Config::get('debug')) $this->apiQueries[] = $clanDetails;
        } catch (Exception $exception) {
            throw ApiException::copy($exception);
        }

        try {
            $clanMembers = BungieNetPlatform::getClanMembers(
                $clanId, 
                $page
            );
            if (Config::get('debug')) $this->apiQueries[] = $clanMembers;
        } catch (Exception $exception) {
            throw ApiException::copy($exception);
        }

        $data['clanName'] = $clanDetails->detail->name;
        $data['id'] = $clanId;
        $data['total'] = $clanMembers->totalResults;
        $data['page'] = $page;
        $data['players'] = array_map(function($item) {
            $member = new stdClass();
            $member->membershipType = $item->destinyUserInfo->membershipType;
            $member->membershipId = $item->destinyUserInfo->membershipId;
            $member->displayName = $item->destinyUserInfo->displayName;
            $member->timePlayed = 0;
            return $member;
        }, $clanMembers->results);

		if (Config::get('debug') && $debug) {
			$data['debug'] = true;
			$data['apiQueries'] = $this->apiQueries;
		}

        return $data;
    }

}