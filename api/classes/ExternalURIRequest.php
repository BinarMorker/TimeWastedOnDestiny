<?php

/**
 * External HTTP request
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class ExternalURIRequest {
	
	/**
	 * The URI to query
	 * @var string
	 */
	private $uri = "";
	
	/**
	 * @param string $uri The URI to set for the request
	 */
	public function __construct($uri) {
		$this->uri = $uri;
	}

	/**
	 * Add parameters to the request
	 * @param array $params An associative array of parameters
	 */
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
	
	/**
	 * Request the set URI and return its content
	 * @param string $method The request method (GET, POST, etc)
	 * @param string $header Other http request header parameters
	 * @return The response body
	 * @throws ExternalURIRequestException
	 */
	public function query($method, $header) {
		$context = stream_context_create(array(
			"http" => array(
				"method" => $method, 
				"header" => $header
			)
		));
		// This line is made error-free for proper error handling afterwards
		$content = @file_get_contents($this->uri, false, $context);
		
		if ($content === false) {
			throw new ExternalURIRequestException();
		}
		
		return $content;
	}
}