<?php

class BungieNetPlatform {
	
	const BUNGIE_URI = "https://www.bungie.net/Platform/";
	
	public static function getBungieAccount(
		$membershipType, 
		$membershipId, 
		$params = null
	) {
		try {
			$uri = new HttpFileRequest(
				self::BUNGIE_URI.
				"User/".
				"getBungieAccount/".
				$membershipId."/".
				$membershipType
			);
			$uri->addParams($params);
			$result = json_decode(preg_replace(
				'/NaN/', 
				'"NaN"', 
				$uri->query("GET", Config::get('apiKey'))
			));
			
			if (in_array(
				$result->ErrorCode, 
				BungieNetPlatformError::getErrors()
			)) {
				throw new BungieNetPlatformException(
					$result->Message, 
					$result->ErrorCode
				);
			}
		} catch (HttpFileRequestException $exception) {
			throw new BungieNetPlatformException(
				'Could not access Bungie at this time.', 
				500
			);
		}
		
		return $result->Response;
	}
	
	public static function searchDestinyPlayer(
		$membershipType, 
		$displayName, 
		$params = null
	) {
		try {
			$uri = new HttpFileRequest(
				self::BUNGIE_URI.
				"Destiny/".
				"SearchDestinyPlayer/".
				$membershipType."/".
				$displayName
			);
			$uri->addParams($params);
			$result = json_decode(preg_replace(
				'/NaN/', 
				'"NaN"', 
				$uri->query("GET", Config::get('apiKey'))
			));

			if (in_array(
				$result->ErrorCode, 
				BungieNetPlatformError::getErrors()
			)) {
				throw new BungieNetPlatformException(
					$result->Message, 
					$result->ErrorCode
				);
			}
		} catch (HttpFileRequestException $exception) {
			throw new BungieNetPlatformException(
				'Could not find the player at this time.', 
				500
			);
		}

		return $result->Response;
	}
	
	public static function getAccountStats(
		$membershipType, 
		$membershipId, 
		$params = null
	) {
		try {
			$uri = new HttpFileRequest(
				self::BUNGIE_URI.
				"Destiny/".
				"Stats/".
				"Account/".
				$membershipType."/".
				$membershipId
			);
			$uri->addParams($params);
			$result = json_decode(preg_replace(
				'/NaN/', 
				'"NaN"', 
				$uri->query("GET", Config::get('apiKey'))
			));

			if (in_array(
				$result->ErrorCode, 
				BungieNetPlatformError::getErrors()
			)) {
				throw new BungieNetPlatformException(
					$result->Message, 
					$result->ErrorCode
				);
			}
		} catch (HttpFileRequestException $exception) {
			throw new BungieNetPlatformException(
				'Could not access stats at this time.', 
				500
			);
		}

		return $result->Response;
	}
	
}