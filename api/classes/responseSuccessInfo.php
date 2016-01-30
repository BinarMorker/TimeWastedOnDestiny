<?php

class ResponseSuccessInfo extends ResponseInfo {
	
	public function getErrorCode() {
		return 0;
	}
	
	public function getMessage() {
		return 'OK';
	}
	
}