<?php

/**
 * JSON builder for API response
 * @author Fran�ois Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class JsonBuilder {
	
	/**
	 * The generated JSON array
	 * @var array
	 */
	protected $json;
	
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
	
	/**
	 * Get the JSON array
	 * @return The JSON array
	 */
	public function get() {
		return $this->json;
	}
	
}