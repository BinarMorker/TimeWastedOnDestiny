<?php

/**
 * Simple document caching
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.11
 */
class Cache {
	
	/**
	 * Get the hash used for cache files
	 * @param string $string The string to be hashed
	 * @return The hashed string
	 */
	public static function hash($string) {
		return md5($string);
	}
	
	/**
	 * Get the cached content if it is valid and in cache, or cache it
	 * @param string $string The content id
	 * @param string $content The content to be cached
	 * @return The cached data
	 */
	public static function getCachedContent($string, $callback) {
		$cacheFile = $_SERVER['DOCUMENT_ROOT'].'/cache/'.self::hash($string);
	
		if (Config::get('shouldCache') === true) {
			if (file_exists($cacheFile) 
			 && abs(filemtime($cacheFile) - time()) < (60 * 60)) {
				$data = file_get_contents($cacheFile);
			} else {
				$data = $callback();
				file_put_contents($cacheFile, $data);
			}
		} else {
			$data = $callback();
		}
		
		return $data;
	}
	
}