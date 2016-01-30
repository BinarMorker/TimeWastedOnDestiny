<?php

class HttpRequest {
	
	private $uri = "";
	
	public function __construct($uri) {
		$this->uri = $uri;
	}

	public function addParams($params = null) {
		if (!is_null($params) && is_array($params)) {
			$joined_params = array();
				
			foreach ($params as $key => $value) {
				if (!empty($key) || !is_numeric($key)) {
					$joined_params[] = "$key=$value";
				} else {
					$joined_params[] = $value;
				}
			}
				
			$this->uri .= '?'.implode('&', $joined_params);
		}
	}
	
	public function query($method, $header) {
		$context = stream_context_create(array(
			"http" => array(
				"method" => $method, 
				"header" => $header
			)
		));
		$content = @file_get_contents($this->uri, false, $context);
		
		if ($content === false) {
			throw new HttpRequestException();
		}
		
		return $content;
	}
}