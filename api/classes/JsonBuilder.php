<?php

class JsonBuilder {
	
	protected $json;
	
	public function __construct($response, JsonInfoBuilder $info) {
		$json = array();
		$json['Response'] = $response;
		$json['Info'] = $info->get();
		$this->json = $json;
	}
	
	public function get() {
		return $this->json;
	}
	
}