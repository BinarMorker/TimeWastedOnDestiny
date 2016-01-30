<?php

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