<?php

/**
 * A wrapper of Bungie Net Platform
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class BungieNetPlatform {
	
	/**
	 * The Bungie Net Platform's URI
	 * @var string
	 */
	const BUNGIE_URI = "https://www.bungie.net/Platform/";
	
	/**
	 * Get the Bungie account from a Destiny account
	 * @param int $membershipType The Destiny account console
	 * @param string $membershipId The Destiny account Id
	 * @param array $params Other parameters link language and definition
	 * @return The response object
	 * @throws BungieNetPlatformException
	 * @link https://www.bungie.net/platform/user/help/HelpDetail/GET?uri=GetBungieAccount%2f%7bmembershipId%7d%2f%7bmembershipType%7d%2f
	 */
	public static function getBungieAccount(
		$membershipType, 
		$membershipId, 
		$params = null
	) {
		try {
			$uri = new ExternalURIRequest(
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
		} catch (ExternalURIRequestException $exception) {
			throw new BungieNetPlatformException(
				'Could not access Bungie at this time.', 
				500
			);
		}
		
		return $result->Response;
	}

	/**
	 * Get a Destiny account from console credentials
	 * @param int $membershipType The console identifier
	 * @param string $displayName The console username
	 * @param array $params Other parameters link language and definition
	 * @return The response object
	 * @throws BungieNetPlatformException
	 * @link https://www.bungie.net/platform/destiny/help/HelpDetail/GET?uri=SearchDestinyPlayer%2f%7bmembershipType%7d%2f%7bdisplayName%7d%2f
	 */
	public static function searchDestinyPlayer(
		$membershipType, 
		$displayName, 
		$params = null
	) {
		try {
			$uri = new ExternalURIRequest(
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
		} catch (ExternalURIRequestException $exception) {
			throw new BungieNetPlatformException(
				'Could not find the player at this time.', 
				500
			);
		}

		return $result->Response;
	}

	/**
	 * Get all stats for a Destiny account
	 * @param int $membershipType The Destiny account console
	 * @param string $membershipId The Destiny account Id
	 * @param array $params Other parameters link language and definition
	 * @return The response object
	 * @throws BungieNetPlatformException
	 * @link https://www.bungie.net/platform/destiny/help/HelpDetail/GET?uri=Stats%2fAccount%2f%7bmembershipType%7d%2f%7bdestinyMembershipId%7d%2f
	 */
	public static function getAccountStats(
		$membershipType, 
		$membershipId, 
		$params = null
	) {
		try {
			$uri = new ExternalURIRequest(
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
		} catch (ExternalURIRequestException $exception) {
			throw new BungieNetPlatformException(
				'Could not access stats at this time.', 
				500
			);
		}

		return $result->Response;
	}
	
}