<?php

/**
 * List Bungie Net Platform errors
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.10
 */
class BungieNetPlatformError {

	/**
	 * ErrorCode 5 means servers are in maintenance
	 * @var integer
	 */
	const maintenanceError = 5;
	
	/**
	 * ErrorCode 2102 means the API key is not set or wrong
	 * @var integer
	 */
	const badKeyError = 2102;
	
	/**
	 * ErrorCode 1618 means Bungie has some problems (weird)
	 * @var integer
	 */
	const bungieServerError = 1618;
	
	/**
	 * ErrorCode 1665 means the information is private
	 * @var integer
	 */
	const privacySettingsError = 1665;

	/**
	 * ErrorCode 1670 means the account is on a legacy console
	 * @var integer
	 */
	const legacyConsoleError = 1670;
	
	/**
	 * Get all errors in an array
	 * @return integer[] The error array
	 */
	public static function getErrors() {
		return array(
			self::maintenanceError, 
			self::badKeyError, 
			self::bungieServerError, 
			self::privacySettingsError, 
			self::legacyConsoleError
		);
	}
	
}