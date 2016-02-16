<?php

/**
 * JSON builder for information block inside response
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class JsonInfoBuilder extends JsonBuilder {
	
	/**
	 * @param ResponseInfo $info API error information, time, etc
	 */
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