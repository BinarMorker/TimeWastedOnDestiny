<?php

/**
 * Route the requests and return the results in JSON
 * @author François Allard <binarmorker@gmail.com>
 * @version 2.1.0
 */
class Api {

	/**
	 * The current API version
	 * @var string
	 */
	const VERSION = "2.2.0";
	
	/**
	 * The main website's domain name
	 * @var string
	 */
	const DOMAIN = "www.wastedondestiny.com";
	
	/**
	 * The warning status if something went wrong
	 * @var string
	 */
	private static $warnStatus;

	/**
	 * Make the request and dispatch to the right subroutine
	 */
	public static function request() {
		Timer::start();
		$helpFile = file_get_contents('help.html');
		
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (isset($_GET['help'])) {
				self::displayHTML($helpFile);
			} elseif (isset($_GET['version'])) {
				$response = self::getVersion();
				self::displayJson($response);
            } elseif (isset($_GET['calculatePercentiles'])) {
                $response = self::calculatePercentiles();
                self::displayJson($response);
			} elseif (isset($_GET['leaderboard'])) {
				if (isset($_GET['page'])) {
					self::displayJson(json_decode(Cache::getCachedContent(
						'leaderboard-'.$_GET['page'],
						600, // 10 minutes is 600 seconds
						function() {
							$response = self::getLeaderboard($_GET['page']);
							return json_encode($response);
						}
					)));
				} else {
					self::displayJson(json_decode(Cache::getCachedContent(
						'leaderboard-1',
						600, // 10 minutes is 600 seconds
						function() {
							$response = self::getLeaderboard(1);
							return json_encode($response);
						}
					)));
				}
			} elseif (isset($_GET['clan'])) {
				if (isset($_GET['page'])) {
					self::displayJson(json_decode(Cache::getCachedContent(
						$_GET['clan'].'-'.$_GET['page'],
						7200, // 2 hours is 7200 seconds
						function() {
							$response = self::getClan($_GET['clan'], $_GET['page']);
							return json_encode($response);
						}
					)));
				} else {
					self::displayJson(json_decode(Cache::getCachedContent(
						$_GET['clan'].'-1',
						7200, // 2 hours is 7200 seconds
						function() {
							$response = self::getClan($_GET['clan'], 1);
							return json_encode($response);
						}
					)));
				}
			} elseif (isset($_GET['console']) && isset($_GET['user'])) {
				self::displayJson(json_decode(Cache::getCachedContent(
					$_GET['console'].'-'.$_GET['user'], 
					3600, // 1 hour is 3600 seconds
					function() {
						$response = self::getTimeWasted($_GET['console'], $_GET['user']);
						return json_encode($response);
					}
				)));
			} else {
				self::displayHTML($helpFile);
			}
		}
	}

	/**
	 * Set the API's warning status
	 * @param string $message The message to put in the warning status
	 */
	public static function setWarnStatus($message) {
		self::$warnStatus = $message;
	}
	
	/**
	 * Get the API's current and online version
	 * @return array The json request
	 */
	private static function getVersion() {
		$data = array();
		$data['currentVersion'] = self::VERSION;
			
		try {
			if ($_SERVER['HTTP_HOST'] != self::DOMAIN) {
				$request = new ExternalURIRequest('http://'.self::DOMAIN.'/api/');
				$request->addParams(array('version'));
				$result = json_decode($request->query('GET'));
				$version = $result->Response->currentVersion;
			} else {
				$version = self::VERSION;
			}
			
			$data['onlineVersion'] = $version;
			$json = new JsonResponseBuilder($data);
			$json->addInfo(new JsonInfoBuilder(new ResponseSuccessInfo()));
			return $json->get();
		} catch (ExternalURIRequestException $exception) {
			$data['onlineVersion'] = self::VERSION;
			$status = new ResponseExceptionInfo($exception);
			$json = new JsonResponseBuilder($data, new JsonInfoBuilder($status));
			return $json->get();
		}
	}

    /**
     * Calculate all stats percentiles
     * @return array The json request
     */
    private static function calculatePercentiles() {
        $data = array();

        try {
            $total = Leaderboard::getTotalPlayers();

            for ($i = 1; $i < 100; $i++) {
                $rank = ceil(((100 - $i) / 100) * $total);
                $data[$i] = Leaderboard::getSecondsAtRank($rank);
            }

            $data[1] = PHP_INT_MAX;
            $data[100] = 0;
            Leaderboard::savePercentiles($data);
            $json = new JsonResponseBuilder($data);
            $json->addInfo(new JsonInfoBuilder(new ResponseSuccessInfo()));
            return $json->get();
        } catch (ExternalURIRequestException $exception) {
            $data['onlineVersion'] = self::VERSION;
            $status = new ResponseExceptionInfo($exception);
            $json = new JsonResponseBuilder($data, new JsonInfoBuilder($status));
            return $json->get();
        }
    }

	/**
	 * Get the time spent on Destiny (and all the user stuff too)
	 * @param int $console
	 * @param string $username
	 * @return array The json request
	 */
	private static function getTimeWasted($console, $username) {
		try {
			$account = new AccountManager($console, $username);
			if (isset($_GET['dbg'])) {
				$json = new JsonResponseBuilder($account->getTimeWasted(true));
			} else {
				$json = new JsonResponseBuilder($account->getTimeWasted());
			}
				
			if (empty(self::$warnStatus)) {
				$status = new ResponseSuccessInfo();
			} else {
				$status = new ResponseWarningInfo(self::$warnStatus);
			}

			$json->addInfo(new JsonInfoBuilder($status));
			return $json->get();
		} catch (ApiException $exception) {
			$status = new ResponseExceptionInfo($exception);
			$json = new JsonResponseBuilder(array(), new JsonInfoBuilder($status));
			return $json->get();
		}
	}

	/**
	 * Get a clan's leaderboard
	 * @param int $id
	 * @param int $page
	 * @return array The json request
	 */
	private static function getClan($id, $page) {
		try {
			$clan = new ClanManager();

			if (isset($_GET['dbg'])) {
				$json = new JsonResponseBuilder($clan->getClanLeaderboard($id, $page, true));
			} else {
				$json = new JsonResponseBuilder($clan->getClanLeaderboard($id, $page));
			}
				
			if (empty(self::$warnStatus)) {
				$status = new ResponseSuccessInfo();
			} else {
				$status = new ResponseWarningInfo(self::$warnStatus);
			}

			$json->addInfo(new JsonInfoBuilder($status));
			return $json->get();
		} catch (ApiException $exception) {
			$status = new ResponseExceptionInfo($exception);
			$json = new JsonResponseBuilder(array(), new JsonInfoBuilder($status));
			return $json->get();
		}
	}

	/**
	 * Get the leaderboard from the database
	 * @param int $page
	 * @return array The json request
	 */
	private static function getLeaderboard($page) {
		try {
			$request = Leaderboard::getTopTen($page);
			$leaderboard = array();
			$count = 0;
			
			foreach ($request as $row) {
				$leaderboard['leaderboard'][$count]['rank'] = $count + (($page * 10) - 10) + 1;
				$leaderboard['leaderboard'][$count]['displayName'] = $row['username'];
				$leaderboard['leaderboard'][$count]['membershipId'] = $row['id'];
				$leaderboard['leaderboard'][$count]['membershipType'] = $row['console'] + 1;
				$leaderboard['leaderboard'][$count]['timePlayed'] = $row['seconds'];
				$count++;
			}
			
			$leaderboard['page'] = $page;
			$leaderboard['totalPlayers'] = Leaderboard::getTotalPlayers();
				
			if (empty(self::$warnStatus)) {
				$status = new ResponseSuccessInfo();
			} else {
				$status = new ResponseWarningInfo(self::$warnStatus);
			}
				
			$json = new JsonResponseBuilder($leaderboard);
			$json->addInfo(new JsonInfoBuilder($status));
			return $json->get();
		} catch (ApiException $exception) {
			$status = new ResponseExceptionInfo($exception);
			$json = new JsonResponseBuilder(array(), new JsonInfoBuilder($status));
			return $json->get();
		}
	}
	
	/**
	 * Display the response as HTML
	 * @param string $response
	 */
	private static function displayHTML($response) {
		header("Content-Type: text/html");
		echo $response;
	}
	
	/**
	 * Display the response as formatted or unformatted json
	 * @param array|stdClass $response
	 */
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