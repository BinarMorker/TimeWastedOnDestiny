<?php

class JsonInfoBuilder extends JsonBuilder {
	
	public function __construct(ResponseInfo $info) {
		$json = array();
		$json['Status'] = $info->getStatus();
		$json['Code'] = $info->getErrorCode();
		$json['Message'] = $info->getMessage();
		$json['LoadTime'] = Timer::stop();
		$json['CacheTime'] = (new DateTime())->format("r");
		$json['ApiVersion'] = Api::VERSION;
		$this->json = $json;
	}
	
}