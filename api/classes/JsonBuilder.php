<?php

/**
 * JSON builder for API response
 * @author François Allard <binarmorker@gmail.com>
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
	public function __construct($response, JsonInfoBuilder $info) {
		$json = array();
		$json['Response'] = $response;
		$json['Info'] = $info->get();
		$this->json = $json;
	}
	
	/**
	 * Get the JSON array
	 * @return The JSON array
	 */
	public function get() {
		return $this->json;
	}
	
}