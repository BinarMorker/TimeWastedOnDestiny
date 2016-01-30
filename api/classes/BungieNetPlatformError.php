<?php

class BungieNetPlatformError {

	/**
	 * ErrorCode 5 means servers are in maintenance
	 * @var integer maintenanceError
	 */
	const maintenanceError = 5;
	
	/**
	 * ErrorCode 2102 means the API key is not set or wrong
	 * @var integer badKeyError
	 */
	const badKeyError = 2102;
	
	/**
	 * ErrorCode 1618 means Bungie has some problems (weird)
	 * @var integer bungieServerError
	 */
	const bungieServerError = 1618;
	
	/**
	 * ErrorCode 1665 means the information is private
	 * @var integer privacySettingsError
	 */
	const privacySettingsError = 1665;
	
	public static function getErrors() {
		return array(
			self::maintenanceError, 
			self::badKeyError, 
			self::bungieServerError, 
			self::privacySettingsError
		);
	}
	
}