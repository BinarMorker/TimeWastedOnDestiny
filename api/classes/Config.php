<?php

class Config {
	
	private $config;
	private static $instance;
	
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
	
	private static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new static();
		}
		
		return self::$instance;
	}
	
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