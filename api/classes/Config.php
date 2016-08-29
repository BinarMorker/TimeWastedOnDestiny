<?php

/**
 * Configuration reader
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class Config {
	
	/**
	 * The content of the configuration file
	 * @var array
	 */
	private $config;
	
	/**
	 * The current instance for the configuration object
	 * @var Config
	 */
	private static $instance;
	
	/**
	 * @throws UnexpectedValueException if the configuration file does not exist
	 */
	private function __construct() {
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/config.json')) {
			$this->config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.json'), true);
		} else {
			throw new UnexpectedValueException(
				'The configuration file does not exist.', 
				1
			);
		}
	}
	
	/**
	 * Get the configuration instance or create it
	 * @return The instance
	 */
	private static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new static();
		}
		
		return self::$instance;
	}
	
	/**
	 * Get the configuration value for a given key
	 * @param string $name The configuration key
	 * @return The configuration value
	 * @throws InvalidArgumentException if the key does not exist
	 */
	public static function get($name) {
		if (array_key_exists($name, self::getInstance()->config)) {
			return self::getInstance()->config[$name];
		} else {
			throw new InvalidArgumentException(
				'Could not find the key in the configuration file.', 
				2
			);
		}
	}
	
}