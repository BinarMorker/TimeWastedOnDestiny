<?php

/**
 * ExternalURIRequest exception
 * @author Fran�ois Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class ExternalURIRequestException extends Exception {
	
	public function __construct($uri, $error) {
		$message = "URI: " . $uri . 
				   "\nError" . $error;
		parent::__construct($message);
	}
	
}