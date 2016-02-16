<?php

/**
 * Warning response info implementation
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class ResponseWarningInfo extends ResponseInfo {
	
	/**
	 * The warning message
	 * @var string
	 */
	private $message;
	
	/**
	 * @param string $message The message to display
	 */
	public function __construct($message) {
		$this->message = $message;
	}
	
	public function getStatus() {
		return 'Warning';
	}
	
	public function getErrorCode() {
		return 1;
	}

	public function getMessage() {
		return $this->message;
	}
	
}