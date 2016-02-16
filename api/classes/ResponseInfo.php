<?php

/**
 * The response info block definition
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
abstract class ResponseInfo {

	/**
	 * Get the request status
	 */
	abstract function getStatus();
	
	/**
	 * Get the error code
	 */
	abstract function getErrorCode();
	
	/**
	 * Get the message
	 */
	abstract function getMessage();

}