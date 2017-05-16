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
	 * Possible http errors to catch
	 * @var array
	 */
	public static $errors = array(
		400,
		401,
		403,
		404,
		500,
		501,
		503
	);
	
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
	 * @return string The response body
	 * @throws ExternalURIRequestException
	 */
	public function query($method, $header = '') {
        // Just why!?
        $escaped_uri = str_replace(' ', '%20', $this->uri);
		$curl = curl_init($escaped_uri);
		curl_setopt_array($curl, array(
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CUSTOMREQUEST => $method, 
			CURLOPT_HTTPHEADER => array($header),
			CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 2
		));
		$content = curl_exec($curl);
		
		if (curl_errno($curl) != 0 || in_array(curl_getinfo($curl, CURLINFO_HTTP_CODE), self::$errors)) {
			throw new ExternalURIRequestException($escaped_uri, curl_error($curl));
		}
		
		curl_close($curl);
		return $content;
	}
}