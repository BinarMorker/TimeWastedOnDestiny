<?php

class JsonInfoBuilder extends JsonBuilder {
	
	public function __construct(ResponseInfo $info) {
		global $dat;
		$json = array();
		$json['Status'] = $info->getErrorCode();
		$json['Message'] = $info->getMessage();
		$json['LoadTime'] = Timer::stop();
		$json['CacheTime'] = (new DateTimeImmutable())->format("r");
		$json['ApiVersion'] = Api::VERSION;
		$this->json = $json;
	}
	
}