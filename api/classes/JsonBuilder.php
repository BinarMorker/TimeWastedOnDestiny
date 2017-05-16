<?php

/**
 * JSON builder for API response
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
abstract class JsonBuilder {
	
	/**
	 * The generated JSON array
	 * @var array
	 */
	protected $json;

	/**
	 * Get the JSON array
	 * @return array The JSON array
	 */
	public function get() {
		return $this->json;
	}
	
}