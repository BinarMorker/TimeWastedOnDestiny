<?php

/**
 * Success response info implementation
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class ResponseSuccessInfo extends ResponseInfo {
	
	public function getStatus() {
		return 'Success';
	}
	
	public function getErrorCode() {
		return 0;
	}
	
	public function getMessage() {
		return 'OK';
	}
	
}