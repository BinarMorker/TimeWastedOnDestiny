<?php

namespace Apine\Controllers\User;

use Apine\Application\Application;
use Apine\Exception\GenericException;
use Apine\Modules\BungieNetPlatform\Destiny2\BungieMembershipType;
use Apine\Modules\BungieNetPlatform\Destiny2\DestinyComponentType;
use Apine\Modules\WOD\Account;
use Apine\Modules\WOD\ApiResponse;
use Apine\Modules\WOD\BungieNetUser;
use Apine\Modules\WOD\Character;
use Apine\Modules\WOD\DestinyClassType;
use Apine\Modules\WOD\DestinyGameVersion;
use Apine\Modules\WOD\DestinyGenderType;
use Apine\Modules\WOD\DestinyRaceType;
use Apine\Modules\WOD\LeaderboardEntry;
use Apine\Modules\WOD\LeaderboardManager;
use Apine\Modules\WOD\Membership;
use Apine\Modules\WOD\Request\Destiny;
use Apine\Modules\WOD\Request\Destiny2;
use Apine\MVC\Controller;
use Apine\MVC\JSONView;
use DateTime;

class BungieController extends Controller {

    /**
     * @param $membershipType
     * @param $membershipId
     * @return array
     */
    private function getMembershipsById($membershipType, $membershipId) {
        $endpointCalls = [];
        $getMembershipsByIdRequest = new Destiny2\GetMembershipsByIdRequest($membershipType, $membershipId);
        $getMembershipsByIdResponse = $getMembershipsByIdRequest->getResponse();
        $endpointCalls[] = $getMembershipsByIdRequest->getInfo();
        $code = $getMembershipsByIdResponse->errorCode;
        $message = $getMembershipsByIdResponse->message;
        $response = new Membership();

        if (!is_null($getMembershipsByIdResponse->response)) {
            if (!is_null($getMembershipsByIdResponse->response->bungieNetUser)) {
                $response->bungieNetUser = new BungieNetUser();
                $response->bungieNetUser->membershipId = $getMembershipsByIdResponse->response->bungieNetUser->membershipId;
                $response->bungieNetUser->displayName = $getMembershipsByIdResponse->response->bungieNetUser->displayName;
            }

            if (!is_null($getMembershipsByIdResponse->response->destinyMemberships)) {
                foreach ($getMembershipsByIdResponse->response->destinyMemberships as $membership) {

                    switch ($membership->membershipType) {
                        case BungieMembershipType::TigerXbox:
                            $getProfileRequest = new Destiny\GetAccountRequest($membership->membershipType, $membership->membershipId);
                            $getProfileResponse = $getProfileRequest->getResponse();
                            $endpointCalls[] = $getProfileRequest->getInfo();

                            if (!is_null($getProfileResponse->response)) {
                                $account = new Account();
                                $account->dateLastPlayed = $getProfileResponse->response->data->dateLastPlayed;
                                $account->membershipId = $membership->membershipId;
                                $account->membershipType = $membership->membershipType;
                                $account->gameVersion = DestinyGameVersion::Destiny;
                                $account->displayName = $membership->displayName;
                                $response->destinyAccounts[] = $account;
                            }

                            $getProfileRequest = new Destiny2\GetProfileRequest($membership->membershipType, $membership->membershipId, [DestinyComponentType::Profiles]);
                            $getProfileResponse = $getProfileRequest->getResponse();
                            $endpointCalls[] = $getProfileRequest->getInfo();

                            if (!is_null($getProfileResponse->response)) {
                                $account = new Account();
                                $account->dateLastPlayed = $getProfileResponse->response->profile->data->dateLastPlayed;
                                $account->membershipId = $membership->membershipId;
                                $account->membershipType = $membership->membershipType;
                                $account->gameVersion = DestinyGameVersion::Destiny2;
                                $account->displayName = $membership->displayName;
                                $response->destinyAccounts[] = $account;
                            }

                            break;
                        case BungieMembershipType::TigerPsn:
                            $getProfileRequest = new Destiny\GetAccountRequest($membership->membershipType, $membership->membershipId);
                            $getProfileResponse = $getProfileRequest->getResponse();
                            $endpointCalls[] = $getProfileRequest->getInfo();

                            if (!is_null($getProfileResponse->response)) {
                                $account = new Account();
                                $account->dateLastPlayed = $getProfileResponse->response->data->dateLastPlayed;
                                $account->membershipId = $membership->membershipId;
                                $account->membershipType = $membership->membershipType;
                                $account->gameVersion = DestinyGameVersion::Destiny;
                                $account->displayName = $membership->displayName;
                                $response->destinyAccounts[] = $account;
                            }

                            $getProfileRequest = new Destiny2\GetProfileRequest($membership->membershipType, $membership->membershipId, [DestinyComponentType::Profiles]);
                            $getProfileResponse = $getProfileRequest->getResponse();
                            $endpointCalls[] = $getProfileRequest->getInfo();

                            if (!is_null($getProfileResponse->response)) {
                                $account = new Account();
                                $account->dateLastPlayed = $getProfileResponse->response->profile->data->dateLastPlayed;
                                $account->membershipId = $membership->membershipId;
                                $account->membershipType = $membership->membershipType;
                                $account->gameVersion = DestinyGameVersion::Destiny2;
                                $account->displayName = $membership->displayName;
                                $response->destinyAccounts[] = $account;
                            }

                            break;
                        case BungieMembershipType::TigerBlizzard:
                            $getProfileRequest = new Destiny2\GetProfileRequest($membership->membershipType, $membership->membershipId, [DestinyComponentType::Profiles]);
                            $getProfileResponse = $getProfileRequest->getResponse();
                            $endpointCalls[] = $getProfileRequest->getInfo();

                            if (!is_null($getProfileResponse->response)) {
                                $account = new Account();
                                $account->dateLastPlayed = $getProfileResponse->response->profile->data->dateLastPlayed;
                                $account->membershipId = $membership->membershipId;
                                $account->membershipType = $membership->membershipType;
                                $account->gameVersion = DestinyGameVersion::Destiny2;
                                $account->displayName = $membership->displayName;
                                $response->destinyAccounts[] = $account;
                            }

                            break;
                    }
                }
            }
        }

        return [$response, $code, $message, $endpointCalls];
    }

    /**
     * @param $membershipType
     * @param $membershipId
     * @return array
     */
    private function getDestinyAccountCharacters($membershipType, $membershipId) {
        $endpointCalls = [];
        $getHistoricalStatsForAccountRequest = new Destiny\GetHistoricalStatsForAccountRequest($membershipType, $membershipId);
        $getHistoricalStatsForAccountResponse = $getHistoricalStatsForAccountRequest->getResponse();
        $endpointCalls[] = $getHistoricalStatsForAccountRequest->getInfo();
        $code = $getHistoricalStatsForAccountResponse->errorCode;
        $message = $getHistoricalStatsForAccountResponse->message;
        $response = [];

        $getProfileRequest = new Destiny\GetAccountRequest($membershipType, $membershipId);
        $getProfileResponse = $getProfileRequest->getResponse();
        $endpointCalls[] = $getProfileRequest->getInfo();

        if ($getProfileResponse->errorCode != 1) {
            $code = $getProfileResponse->errorCode;
            $message = $getProfileResponse->message;
        }

        if (!is_null($getHistoricalStatsForAccountResponse->response)) {
            foreach ($getHistoricalStatsForAccountResponse->response->characters as $characterStats) {
                $character = new Character();
                $character->characterId = $characterStats->characterId;
                $character->deleted = $characterStats->deleted;
                $character->timePlayed = $characterStats->merged->allTime['secondsPlayed']->basic->value;

                foreach ($getProfileResponse->response->data->characters as $characterData) {
                    if ($characterData->characterBase->characterId == $character->characterId) {
                        $character->backgroundPath = $characterData->backgroundPath;
                        $character->emblemPath = $characterData->emblemPath;

                        switch ($characterData->characterBase->classType) {
                            case DestinyClassType::Titan:
                                $character->charClass = "Titan";
                                break;
                            case DestinyClassType::Hunter:
                                $character->charClass = "Hunter";
                                break;
                            case DestinyClassType::Warlock:
                                $character->charClass = "Warlock";
                                break;
                        }

                        switch ($characterData->characterBase->raceHash) {
                            case "3887404748":
                                $character->race = "Human";
                                break;
                            case "2803282938":
                                $character->race = "Awoken";
                                break;
                            case "898834093":
                                $character->race = "Exo";
                                break;
                        }

                        switch ($characterData->characterBase->genderType) {
                            case DestinyGenderType::Male:
                                $character->gender = "Male";
                                break;
                            case DestinyGenderType::Female:
                                $character->gender = "Female";
                                break;
                        }

                        $character->level = $characterData->characterBase->powerLevel;
                        break;
                    }
                }

                $response[] = $character;
            }
        }

        return [$response, $code, $message, $endpointCalls];
    }

    /**
     * @param $membershipType
     * @param $membershipId
     * @return array
     */
    private function getDestiny2AccountCharacters($membershipType, $membershipId) {
        $endpointCalls = [];
        $getProfileRequest = new Destiny2\GetProfileRequest($membershipType, $membershipId, [ DestinyComponentType::Characters ]);
        $getProfileResponse = $getProfileRequest->getResponse();
        $endpointCalls[] = $getProfileRequest->getInfo();
        $code = $getProfileResponse->errorCode;
        $message = $getProfileResponse->message;
        $response = [];

        $getHistoricalStatsForAccountRequest = new Destiny2\GetHistoricalStatsForAccountRequest($membershipType, $membershipId);
        $getHistoricalStatsForAccountResponse = $getHistoricalStatsForAccountRequest->getResponse();
        $endpointCalls[] = $getHistoricalStatsForAccountRequest->getInfo();

        if ($getHistoricalStatsForAccountResponse->errorCode != 1) {
            $code = $getHistoricalStatsForAccountResponse->errorCode;
            $message = $getHistoricalStatsForAccountResponse->message;
        }

        if (!is_null($getHistoricalStatsForAccountResponse->response)) {
            foreach ($getHistoricalStatsForAccountResponse->response->characters as $characterStats) {
                $character = new Character();
                $character->characterId = $characterStats->characterId;
                $character->deleted = $characterStats->deleted;
                $character->timePlayed = $characterStats->merged->allTime['secondsPlayed']->basic->value;

                foreach ($getProfileResponse->response->characters->data as $characterData) {
                    if ($characterData->characterId == $character->characterId) {
                        $character->backgroundPath = $characterData->emblemBackgroundPath;
                        $character->emblemPath = $characterData->emblemPath;

                        switch ($characterData->classType) {
                            case DestinyClassType::Titan:
                                $character->charClass = "Titan";
                                break;
                            case DestinyClassType::Hunter:
                                $character->charClass = "Hunter";
                                break;
                            case DestinyClassType::Warlock:
                                $character->charClass = "Warlock";
                                break;
                        }

                        switch ($characterData->raceType) {
                            case DestinyRaceType::Human:
                                $character->race = "Human";
                                break;
                            case DestinyRaceType::Awoken:
                                $character->race = "Awoken";
                                break;
                            case DestinyRaceType::Exo:
                                $character->race = "Exo";
                                break;
                        }

                        switch ($characterData->genderType) {
                            case DestinyGenderType::Male:
                                $character->gender = "Male";
                                break;
                            case DestinyGenderType::Female:
                                $character->gender = "Female";
                                break;
                        }

                        $character->level = $characterData->light;
                        break;
                    }
                }

                $response[] = $character;
            }
        }

        return [$response, $code, $message, $endpointCalls];
    }

    /**
     * @param $params
     * @param $response
     */
    private function debug($params, &$response) {
        if (!isset($params['debug']) || Application::get_instance()->get_mode() != APINE_MODE_DEVELOPMENT) {
            unset($response->endpointCalls);
        } else {
            if (!isset($params['verbose'])) {
                foreach ($response->endpointCalls as $index => $endpointCall) {
                    unset($response->endpointCalls[$index]['contents']);
                }
            }
        }
    }

    /**
     * Get a specific membership and all associated valid Destiny accounts
     * @link /bungie/getMembership?membershipType=[]&membershipId=[]
     *
     * @param $params
     * @return JSONView
     */
    public function getMembership($params) {
        $start = microtime(true);
        $now = new DateTime();
        $response = new ApiResponse();
        $response->queryTime = $now;
        $view = new JSONView();
        list($response->response, $response->code, $response->message, $response->endpointCalls) = $this->getMembershipsById($params['membershipType'], $params['membershipId']);
        $this->debug($params, $response);
        $response->executionMilliseconds = (microtime(true) - $start) * 1000;
        $view->set_json_file($response);
        return $view;
    }

    /**
     * Search Destiny accounts by name and find all associated valid Destiny accounts
     * @link /bungie/fetchAccounts?membershipType=[]&displayName=[]
     *
     * @param $params
     * @return JSONView
     */
    public function fetchAccounts($params) {
        $start = microtime(true);
        $now = new DateTime();
        $response = new ApiResponse();
        $response->queryTime = $now;
        $view = new JSONView();

        $searchDestinyPlayerRequest = new Destiny2\SearchDestinyPlayerRequest($params['membershipType'], $params['displayName']);
        $searchDestinyPlayerResponse = $searchDestinyPlayerRequest->getResponse();
        $response->endpointCalls[] = $searchDestinyPlayerRequest->getInfo();
        $response->code = $searchDestinyPlayerResponse->errorCode;
        $response->message = $searchDestinyPlayerResponse->message;
        $response->response = new Membership();

        if (!is_null($searchDestinyPlayerResponse->response)) {
            foreach ($searchDestinyPlayerResponse->response as $destinyPlayer) {
                list($membership, $code, $message, $endpointCalls) = $this->getMembershipsById($destinyPlayer->membershipType, $destinyPlayer->membershipId);

                foreach ($endpointCalls as $endpointCall) {
                    $response->endpointCalls[] = $endpointCall;
                }

                if ($code != 1) {
                    $response->code = $code;
                    $response->message = $message;
                }

                if (!is_null($membership)) {
                    if (is_null($response->response->bungieNetUser)) {
                        $response->response->bungieNetUser = $membership->bungieNetUser;
                    }

                    if (!is_null($membership->destinyAccounts)) {
                        foreach ($membership->destinyAccounts as $newMembership) {
                            $found = false;

                            if (!is_null($response->response->destinyAccounts)) {
                                foreach ($response->response->destinyAccounts as $existingMembership) {
                                    if ($existingMembership->membershipId == $newMembership->membershipId && $existingMembership->gameVersion == $newMembership->gameVersion) {
                                        $found = true;
                                    }
                                }
                            }

                            if (!$found) {
                                $response->response->destinyAccounts[] = $newMembership;
                            }
                        }
                    }
                }
            }
        }

        $this->debug($params, $response);
        $response->executionMilliseconds = (microtime(true) - $start) * 1000;
        $view->set_json_file($response);
        return $view;
    }

    /**
     * Fetch Destiny character data for the Destiny account
     * @link /bungie/fetchCharacters?membershipType=[]&membershipId=[]&gameVersion=[]
     *
     * @param $params
     * @return JSONView
     * @throws GenericException
     */
    public function fetchCharacters($params) {
        $start = microtime(true);
        $now = new DateTime();
        $response = new ApiResponse();
        $response->queryTime = $now;
        $view = new JSONView();

        if (!isset($params['gameVersion'])) {
            throw new GenericException("Missing parameter: gameVersion", 400);
        }

        switch (intval($params['gameVersion'])) {
            case DestinyGameVersion::Destiny:
                list($response->response, $response->code, $response->message, $response->endpointCalls) = $this->getDestinyAccountCharacters($params['membershipType'], $params['membershipId']);
                break;
            case DestinyGameVersion::Destiny2:
                list($response->response, $response->code, $response->message, $response->endpointCalls) = $this->getDestiny2AccountCharacters($params['membershipType'], $params['membershipId']);
                break;
        }

        $player = new LeaderboardEntry();
        $player->membershipId = $params['membershipId'];
        $player->membershipType = $params['membershipType'];
        $player->gameVersion = intval($params['gameVersion']);
        $player->timePlayed = array_sum(array_map(function(Character $item) {
            return $item->timePlayed;
        }, $response->response));

        $getMembershipsByIdRequest = new Destiny2\GetMembershipsByIdRequest($params['membershipType'], $params['membershipId']);
        $getMembershipsByIdResponse = $getMembershipsByIdRequest->getResponse();
        $response->endpointCalls[] = $getMembershipsByIdRequest->getInfo();

        foreach ($getMembershipsByIdResponse->response->destinyMemberships as $membership) {
            if ($membership->membershipId == $params['membershipId']) {
                $player->displayName = $membership->displayName;
                break;
            }
        }

        if (LeaderboardManager::playerExists($player)) {
            LeaderboardManager::updatePlayer($player);
        } else {
            LeaderboardManager::newPlayer($player);
        }

        $this->debug($params, $response);
        $response->executionMilliseconds = (microtime(true) - $start) * 1000;
        $view->set_json_file($response);
        return $view;
    }
}