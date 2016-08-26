<?php

/**
 * Manage Destiny accounts and get relevant information
 * @author Fran�ois Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class AccountManager {
	
	/**
	 * The global Bungie account
	 * @var stdClass
	 */
	private $bungieAccount;

	/**
	 * All Destiny accounts linked to the Bungie account
	 * @var array
	 */
	private $destinyAccounts = array();

	/**
	 * All API calls
	 * @var array
	 */
	private $apiQueries = array();
	
	/**
	 * @param int $console
	 * @param string $username
	 * @throws BungieNetPlatformException
	 */
	public function __construct($console, $username) {
		try {
			$playerRequest = BungieNetPlatform::searchDestinyPlayer(
				$console, 
				$username
			);
			if (Config::get('debug')) $this->apiQueries[] = $playerRequest;
		} catch (Exception $exception) {
			throw ApiException::copy($exception);
		}
		
		if (empty($playerRequest)) {
			Api::setWarnStatus("The player was found on another platform");
			
			if ($console == 1) {
				$console = 2;
			} else {
				$console = 1;
			}

			try {
				$playerRequest = BungieNetPlatform::searchDestinyPlayer(
					$console,
					$username
				);
				if (Config::get('debug')) $this->apiQueries[] = $playerRequest;
			} catch (Exception $exception) {
				throw ApiException::copy($exception);
			}
			
			if (empty($playerRequest)) {
				throw new ApiException(
					'Player not found', 
					3
				);
			}
		}

		try {
			$bungieAccountRequest = BungieNetPlatform::getBungieAccount(
				$playerRequest[0]->membershipType, 
				$playerRequest[0]->membershipId
			);
			if (Config::get('debug')) $this->apiQueries[] = $bungieAccountRequest;
		} catch (Exception $exception) {
			throw ApiException::copy($exception);
		}

		$exclusion = Exclusions::getDestinyAccount(
			$playerRequest[0]->membershipType, 
			$playerRequest[0]->membershipId
		);
		
		if ($exclusion != null) {
			try {
				$extraBungieAccountRequest = BungieNetPlatform::getBungieAccount(
					$playerRequest[0]->membershipType == 1 ? 2 : 1, 
					$playerRequest[0]->membershipType == 1 ? $exclusion->playstation : $exclusion->xbox
				);
				$bungieAccountRequest->destinyAccounts = array_merge(array_filter($bungieAccountRequest->destinyAccounts, function($item) use ($playerRequest) {
					return $item->userInfo->membershipType == $playerRequest[0]->membershipType;
				}), array_filter($extraBungieAccountRequest->destinyAccounts, function($item) use ($playerRequest) {
					return $item->userInfo->membershipType != $playerRequest[0]->membershipType;
				}));
				$bungieAccountRequest->bungieNetUser = new stdClass();
				$bungieAccountRequest->bungieNetUser->displayName = $exclusion->displayName;
				if (Config::get('debug')) $this->apiQueries[] = $bungieAccountRequest;
			} catch (Exception $exception) {
				throw ApiException::copy($exception);
			}
		}

		if (count($bungieAccountRequest->destinyAccounts) > 0) {
			$isCorrectPlatform = false;
			
			foreach ($bungieAccountRequest->destinyAccounts 
				as $destinyAccount) {
				$this->destinyAccounts[] = $destinyAccount;
				
				if ($destinyAccount->userInfo->membershipType == 
					$playerRequest[0]->membershipType) {
					$isCorrectPlatform = true;
				}
			}
			
			if (!$isCorrectPlatform) {
				Api::setWarnStatus(
					'Account found but played an earlier version of the game'
				);
			}
		} else {
			throw new ApiException(
				'Could not access Destiny servers at this time.', 
				500
			);
		}

		unset($bungieAccountRequest->destinyAccounts);
		$this->bungieAccount = $bungieAccountRequest;
	}

	/**
	 * Get the time spent on Destiny (and many other characters information)
	 * @return The information array
	 */
	public function getTimeWasted($debug = false) {
		$data = array();
		
		if (empty($this->bungieAccount->bungieNetUser)) {
			$data['displayName'] = 
				$this->destinyAccounts[0]->userInfo->displayName;
		} else {
			$data['displayName'] = 
				$this->bungieAccount->bungieNetUser->displayName;
		}
		
		$data['totalTimePlayed'] = 0;
		$data['totalTimeWasted'] = 0;
		$data['lastPlayed'] = 0;
		$data['newEntry'] = false;
		$data['xbox'] = null;
		$data['playstation'] = null;
		
		foreach ($this->destinyAccounts as $destinyAccount) {
			if (Leaderboard::isNew(
				$destinyAccount->userInfo->membershipId
			)) {
				$data['newEntry'] = true;
			}
		
			$currentData = array();
			$currentData = $destinyAccount->userInfo;
			
			try {
				$accountStats = BungieNetPlatform::getAccountStats(
					$destinyAccount->userInfo->membershipType, 
					$destinyAccount->userInfo->membershipId
				);
				if (Config::get('debug')) $this->apiQueries[] = $accountStats;
			} catch (Exception $exception) {
				throw ApiException::copy($exception);
			}
			
			/*$currentData->characters = new stdClass();
			$currentData->characters->total = count($accountStats->characters);
			$currentData->characters->deleted = 0;
			
			foreach ($accountStats->characters as $character) {
				if ($character->deleted) {
					$currentData->characters->deleted++;
				}
			}*/

			foreach ($accountStats->characters as $character) {
				$currentCharacter = new stdClass();
				$currentCharacter->characterId = $character->characterId;
				$currentCharacter->deleted = $character->deleted;
				$currentCharacter->timePlayed = $character->merged->allTime->secondsPlayed->basic->value;
				$currentData->characters[] = $currentCharacter;
			}

			if (isset($accountStats->mergedAllCharacters->
				merged->allTime->secondsPlayed->basic->value)) {
				$currentData->timePlayed = 
					$accountStats->mergedAllCharacters->
					merged->allTime->secondsPlayed->basic->value;
				$data['totalTimePlayed'] += $currentData->timePlayed;
			} else {
				$currentData->timePlayed = 0;
			}
			
			if (isset($accountStats->mergedDeletedCharacters->
				merged->allTime->secondsPlayed->basic->value)) {
				$currentData->timeWasted = 
					$accountStats->mergedDeletedCharacters->
					merged->allTime->secondsPlayed->basic->value;
					$data['totalTimeWasted'] += $currentData->timeWasted;
			} else {
				$currentData->timeWasted = 0;
			}
			
			$currentData->lastPlayed = 0;
			
			foreach ($destinyAccount->characters as $character) {
				foreach ($currentData->characters as $key => $currentChar) {
					if ($currentChar->characterId == $character->characterId) {
						$gender = $character->gender->genderName;
						$characterClass = $character->characterClass->{'className'.$gender};
						$race = $character->race->{'raceName'.$gender};
						$currentData->characters[$key]->light = $character->powerLevel;
						$currentData->characters[$key]->characterClass = $characterClass;
						$currentData->characters[$key]->race = $race;
						break;
					}
				}

				$dateLastPlayed = date("U", 
					strtotime($character->dateLastPlayed)
				);
				
				if ($currentData->lastPlayed < $dateLastPlayed) {
					$currentData->lastPlayed = $dateLastPlayed;
					
					if ($data['lastPlayed'] < $dateLastPlayed) {
						$data['lastPlayed'] = $dateLastPlayed;
					}
				}
			}
			
			Leaderboard::addPlayer(
				$destinyAccount->userInfo->membershipType, 
				$destinyAccount->userInfo->membershipId, 
				$destinyAccount->userInfo->displayName, 
				$currentData->timePlayed
			);
			$currentData->leaderboardPosition = Leaderboard::getPlayerRank(
				$destinyAccount->userInfo->membershipId
			);
			
			if ($destinyAccount->userInfo->membershipType == 1) {
				$data['xbox'] = $currentData;
			} elseif ($destinyAccount->userInfo->membershipType == 2) {
				$data['playstation'] = $currentData;
			} else {
				$data['other'] = $currentData;
			}
		}

		if (Config::get('debug') && $debug) {
			$data['debug'] = true;
			$data['apiQueries'] = $this->apiQueries;
			$data['characters'] = array_map(function($x) {
				return $x->characterId;
			}, $accountStats->characters);
			$data['count'] = count($accountStats->characters);
		}
		
		return $data;
	}
}