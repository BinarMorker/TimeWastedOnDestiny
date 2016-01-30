<?php

class AccountManager {
	
	private $bungieAccount;
	private $destinyAccounts = array();
	private $warnStatus;
	
	public function __construct($console, $username) {
		$playerRequest = BungieNetPlatform::searchDestinyPlayer(
			$console, 
			$username
		);
		
		if (empty($playerRequest)) {
			Api::setWarnStatus("The player was found on another platform");
			
			if ($console == 1) {
				$console = 2;
			} else {
				$console = 1;
			}

			$playerRequest = BungieNetPlatform::searchDestinyPlayer(
				$console,
				$username
			);
			
			if (empty($playerRequest)) {
				throw new BungieNetPlatformException(
					'Player not found', 
					3
				);
			}
		}
		
		$bungieAccountRequest = BungieNetPlatform::getBungieAccount(
			$playerRequest[0]->membershipType, 
			$playerRequest[0]->membershipId
		);

		if (count($bungieAccountRequest->destinyAccounts) > 0) {
			foreach ($bungieAccountRequest->destinyAccounts as $destinyAccount) {
				$this->destinyAccounts[] = $destinyAccount;
			}
		} else {
			throw new BungieNetPlatformException(
				'Could not access Destiny servers at this time.', 
				500
			);
		}

		unset($bungieAccountRequest->destinyAccounts);
		$this->bungieAccount = $bungieAccountRequest;
	}

	public function getTimeWasted() {
		$data = array();
		
		if (empty($this->bungieAccount->bungieNetUser)) {
			$data['displayName'] = $this->destinyAccounts[0]->userInfo->displayName;
		} else {
			$data['displayName'] = $this->bungieAccount->bungieNetUser->displayName;
		}
		
		$data['totalTimePlayed'] = 0;
		$data['totalTimeWasted'] = 0;
		$data['lastPlayed'] = 0;
		$data['newEntry'] = false;
		
		foreach ($this->destinyAccounts as $destinyAccount) {
			if (Leaderboard::isNew(
				$destinyAccount->userInfo->membershipId
			)) {
				$data['newEntry'] = true;
			}
		
			$currentData = array();
			$currentData = $destinyAccount->userInfo;
			$accountStats = BungieNetPlatform::getAccountStats(
				$destinyAccount->userInfo->membershipType, 
				$destinyAccount->userInfo->membershipId
			);
			$currentData->characters = new stdClass();
			$currentData->characters->total = count($accountStats->characters);
			$currentData->characters->deleted = 0;
			
			foreach ($accountStats->characters as $character) {
				if ($character->deleted) {
					$currentData->characters->deleted++;
				}
			}

			if (isset($accountStats->mergedAllCharacters->
				merged->allTime->secondsPlayed->basic->value)) {
				$currentData->timePlayed = $accountStats->mergedAllCharacters->
					merged->allTime->secondsPlayed->basic->value;
				$data['totalTimePlayed'] += $currentData->timePlayed;
			} else {
				$currentData->timePlayed = 0;
			}
			
			if (isset($accountStats->mergedDeletedCharacters->
				merged->allTime->secondsPlayed->basic->value)) {
				$currentData->timeWasted = $accountStats->mergedDeletedCharacters->
					merged->allTime->secondsPlayed->basic->value;
					$data['totalTimeWasted'] += $currentData->timeWasted;
			} else {
				$currentData->timeWasted = 0;
			}
			
			$currentData->lastPlayed = 0;
			
			foreach ($destinyAccount->characters as $character) {
				$dateLastPlayed = date("U", strtotime($character->dateLastPlayed));
				
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
		
		return $data;
	}
}