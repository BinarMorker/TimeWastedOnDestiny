<?php

class Cache {
	
	public static function hash($string) {
		return md5($string);
	}
	
	public static function getCachedContent($string, $content) {
		$cacheFile = $_SERVER['DOCUMENT_ROOT'].'/cache/'.self::hash($string);
	
		if (Config::get('shouldCache') === true) {
			if (file_exists($cacheFile) 
			 && abs(filemtime($cacheFile) - time()) < (60 * 60)) {
				$data = file_get_contents($cacheFile);
			} else {
				$data = $content;
				file_put_contents($cacheFile, $data);
			}
		} else {
			$data = $content;
		}
		
		return $data;
	}
	
}