<?php

class ResponseExceptionInfo extends ResponseInfo {
	
	private $errorCode;
	private $message;
	
	public function __construct(Exception $exception) {
		$this->errorCode = $exception->getCode();
		$this->message = $exception->getMessage();
	}
	
	public function getStatus() {
		return 'Error';
	}
	
	public function getErrorCode() {
		return $this->errorCode;
	}

	public function getMessage() {
		return $this->message;
	}
	
}