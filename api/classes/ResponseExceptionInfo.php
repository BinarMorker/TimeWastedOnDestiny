<?php

/**
 * Exception response info implementation
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class ResponseExceptionInfo extends ResponseInfo {
	
	/**
	 * The error code
	 * @var int
	 */
	private $errorCode;
	
	/**
	 * The error message
	 * @var string
	 */
	private $message;
	
	/**
	 * @param Exception $exception The exception to display
	 */
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