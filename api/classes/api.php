<?php

class Api {

	const VERSION = "1.8";
	const DOMAIN = "wastedondestiny.com";
	private static $warnStatus;

	public static function request($helpFile) {
		Timer::start();
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (isset($_GET['help'])) {
				self::displayPlain($helpFile);
			} elseif (isset($_GET['version'])) {
				$response = self::getVersion();
				self::displayJson($response);
			} elseif (isset($_GET['leaderboard'])) {
				$response = self::getLeaderboard();
				self::displayJson($response);
			} elseif (isset($_GET['console']) && isset($_GET['user'])) {
				$response = self::getTimeWasted($_GET['console'], $_GET['user']);
				self::displayCachedJson($_GET['console'].'-'.$_GET['user'], $response);
			} else {
				self::displayPlain($helpFile);
			}
		}
		
	}

	public static function setWarnStatus($message) {
		self::$warnStatus = $message;
	}
	
	private static function getVersion() {
		$data = array();
		$data['currentVersion'] = self::VERSION;
			
		try {
			if ($_SERVER['HTTP_HOST'] != self::DOMAIN) {
				$request = new HttpRequest('http://'.self::DOMAIN.'/api/');
				$request->addParams(array('version'));
				$result = $request->query('GET', Config::get('apiKey'));
			} else {
				$result = self::VERSION;
			}
			
			$data['onlineVersion'] = $result;
			$info = new JsonInfoBuilder(new ResponseSuccessInfo());
			$json = new JsonBuilder($data, $info);
			return $json->get();
		} catch (HttpRequestException $exception) {
			$data['onlineVersion'] = self::VERSION;
			$status = new ResponseExceptionInfo($exception);
			$info = new JsonInfoBuilder($status);
			$json = new JsonBuilder($data, $info);
			return $json->get();
		}
	}

	private static function getTimeWasted($console, $username) {
		try {
			$account = new AccountManager($console, $username);
				
			if (empty(self::$warnStatus)) {
				$status = new ResponseSuccessInfo();
			} else {
				$status = new ResponseWarningInfo(self::$warnStatus);
			}
				
			$info = new JsonInfoBuilder($status);
			$json = new JsonBuilder($account->getTimeWasted(), $info);
			return $json->get();
		} catch (BungieNetPlatformException $exception) {
			$status = new ResponseExceptionInfo($exception);
			$info = new JsonInfoBuilder($status);
			$json = new JsonBuilder(array(), $info);
			return $json->get();
		}
	}

	private static function getLeaderboard() {
		try {
			$request = Leaderboard::getLastTen();
			$leaderboard = array();
			$count = 0;
			
			foreach ($request as $row) {
				$leaderboard['leaderboard'][$count]['displayName'] = $row['username'];
				$leaderboard['leaderboard'][$count]['membershipId'] = $row['id'];
				$leaderboard['leaderboard'][$count]['membershipType'] = $row['console'] + 1;
				$leaderboard['leaderboard'][$count]['timePlayed'] = $row['seconds'];
				$count++;
			}
			
			$leaderboard['totalPlayers'] = Leaderboard::getTotalPlayers();
				
			if (empty(self::$warnStatus)) {
				$status = new ResponseSuccessInfo();
			} else {
				$status = new ResponseWarningInfo(self::$warnStatus);
			}
				
			$info = new JsonInfoBuilder($status);
			$json = new JsonBuilder($leaderboard, $info);
			return $json->get();
		} catch (BungieNetPlatformException $exception) {
			$status = new ResponseExceptionInfo($exception);
			$info = new JsonInfoBuilder($status);
			$json = new JsonBuilder(array(), $info);
			return $json->get();
		}
	}
	
	private static function displayPlain($response) {
		header("Content-Type: text/plain");
		echo $response;
	}
	
	private static function displayCachedJson($string, $response) {
		if (isset($_GET['fmt'])) {
			header("Content-Type: text/plain");
			echo Cache::getCachedContent(
				$string, 
				json_encode($response, JSON_PRETTY_PRINT)
			);
		} else {
			header("Content-Type: application/json");
			echo Cache::getCachedContent(
				$string, 
				json_encode($response)
			);
		}
	}
	
	private static function displayJson($response) {
		if (isset($_GET['fmt'])) {
			header("Content-Type: text/plain");
			echo json_encode($response, JSON_PRETTY_PRINT);
		} else {
			header("Content-Type: application/json");
			echo json_encode($response);
		}
	}

}