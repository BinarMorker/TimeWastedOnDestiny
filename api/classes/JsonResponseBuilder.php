<?php

/**
 * JSON builder for API response
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class JsonResponseBuilder extends JsonBuilder {

	/**
	 * @param mixed $response The data response to put in the JSON
	 * @param JsonInfoBuilder $info The builder's info, errors, time, etc.
	 */
	public function __construct($response, JsonInfoBuilder $info = null) {
		$json = array();
		$json['Response'] = $response;
		
		if (!is_null($info)) {
			$json['Info'] = $info->get();
		}
		
		$this->json = $json;
	}
	
	public function addInfo(JsonInfoBuilder $info) {
		$this->json['Info'] = $info->get();
	}

}