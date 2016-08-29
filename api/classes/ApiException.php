<?php

/**
 * A generic API exception
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class ApiException extends Exception {
	
	public static function copy(Exception $exception) {
		if (Config::get("debug")) {
			$message = get_class($exception) . "\n" . $exception->getMessage() . "\n\n" . $exception->getTraceAsString();
		} else {
			$message = $exception->getMessage();
		}
		
		return new static($message, $exception->getCode(), $exception);
	}
	
}