<?php

class ResponseWarningInfo extends ResponseInfo {
	
	private $message;
	
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