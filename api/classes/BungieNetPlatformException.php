<?php

/**
 * BungieNetPlatform exception
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class BungieNetPlatformException extends Exception {
	
	/**
	 * @param string $message
	 * @param int $code
	 */
	public function __construct ($message = null, $code = null) {
		parent::__construct($message, $code);
	}
	
}