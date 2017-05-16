<?php

/**
 * Simple document caching
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.11
 */
class Cache {
	
	/**
	 * Get the cached content if it is valid and in cache, or cache it
	 * @param string $string The content id
	 * @param int $time The time during which to cache the content
	 * @param callable $callback The content to be cached
	 * @return string The cached data
	 */
	public static function getCachedContent($string, $time, $callback) {
		$cacheFile = $_SERVER['DOCUMENT_ROOT'].'/cache/'.$string.'.json';
	
		if (Config::get('shouldCache') === true) {
			if (file_exists($cacheFile) 
			 && abs(filemtime($cacheFile) - time()) < $time) {
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