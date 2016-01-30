<?php

class BungieNetPlatformException extends Exception {
	
	public function __construct ($message = null, $code = null) {
		parent::__construct($message, $code);
	}
	
}