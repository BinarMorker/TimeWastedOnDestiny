<?php

launch();

function launch() {
	if (isset($_GET['help']) || !isset($_GET['user']) || !isset($_GET['console']) || empty($_GET['user']) || empty($_GET['console'])) {
		// If help is called or the syntax is incorrect
		header("Content-Type: text/plain");
		echo file_get_contents("help.txt"); // Show the help file
	} else {
		$hash = md5($_GET['console'] . "-" . $_GET['user']); // Create a unique hash for the entry
	    $cacheFile = "cache/" . $hash;
	    if (file_exists($cacheFile) && abs(filemtime($cacheFile) - time()) < (60 * 60)) { // 60 seconds x 60 minutes = 1 hour
	    	// If the file exists and hasn't expired, just show the file
	        $data = file_get_contents($cacheFile);
	    } else {
	    	// If the file doesn't exist or has expired, create it and show the data
	        $data = get_time_wasted($_GET['console'], $_GET['user']);
	        file_put_contents($cacheFile, $data);
	    }
	    if (isset($_GET['fmt'])) {
	    	header("Content-Type: text/plain");
	    	echo json_encode(json_decode($data), JSON_PRETTY_PRINT);
	    } else {
	    	header("Content-Type: application/json");
			echo $data;
	    }
	}
}

function get_time_wasted($console, $name) {
	try {
		$timer = new Timer();
		$response = array();
		$account = new DestinyAccount($name, $console);
		$account->lookup();
		$account->get_accounts();
		$response["displayName"] = $account->display_name;
		if (array_key_exists(1, $account->accounts)) {
			// If the account contains an entry for Xbox
			$account->fetch(1);
			$xbl_time = $account->accounts[1];
			$response["xbox"] = $xbl_time;
		}
		if (array_key_exists(2, $account->accounts)) {
			// If the account contains an entry for Playstation
			$account->fetch(2);
			$psn_time = $account->accounts[2];
			$response["playstation"] = $psn_time;
		}
		$response["totalTime"] = $account->total_time;
		$account->error['LoadTime'] = $timer->get_timer();
		$account->error['CacheTime'] = date("r");
		return json_encode(array("Response" => $response, "Info" => $account->error));
	} catch (Exception $e) {
		return json_encode(array("Response" => "", "Info" => $account->error));
	}
}

class DestinyAccount {
	public $name = "";
	public $display_name = "";
	public $console = 0;
	public $accounts = array();
	public $temp_account_id = "";
	public $total_time = 0;
	public $error = array();
	
	function __construct($name, $console) {
		$this->name = $name;
		$this->console = $console;
	}

	function lookup($retry = false) {
		// This endpoint returns the membershipId of a player
		$url = "https://www.bungie.net/platform/destiny/SearchDestinyPlayer/" . $this->console . "/" . $this->name;
		$lookup = file_get_contents($url);
		$response = json_decode($lookup);
		if ($response->ErrorCode == 5) {
			// ErrorCode 5 means servers are in maintenance
			$this->error = Error::show(Error::ERROR, "Destiny is in maintenance");
			throw(new Exception());
		}
		if (!empty($response->Response)) {
			if (!$retry) {
				// Everything is good. Claim $200. Don't go to jail.
				$this->error = Error::show(Error::SUCCESS, "Player found");
			} else {
				// The script had to retry with another console, so it shows a small warning
				$this->error = Error::show(Error::WARNING, "Account found on another platform");
			}
			$this->temp_account_id = $response->Response[0]->membershipId;
		} else {
			if (!$retry) {
				// Glorious console swap on first "Account not found" exception
				$this->swap_console();
				$this->lookup(true);
			} else {
				// That's it, the player can't be found under that name. Bummer.
				$this->error = Error::show(Error::ERROR, "Account not found");
				throw(new Exception());
			}
		}
	}
	
	function swap_console() {
		// If you fail to understand this, I swear to God...
		if ($this->console == 1) {
			$this->console = 2;
		} else if ($this->console == 2) {
			$this->console = 1;
		}
	}

	function add_account($console, $contents) {
		$this->accounts[$console] = $contents;
	}
	
	function add_time($time) {
		$this->total_time += $time;
	}
	
	function get_accounts() {
		// This endpoint returns relevant data on each console account linked to a Bungie account
		$url = "https://www.bungie.net/platform/user/GetBungieAccount/" . $this->temp_account_id . "/" . $this->console;
		$lookup = file_get_contents($url);
		$response = json_decode($lookup);
		if (isset($response->Response->bungieNetUser)) {
			$this->display_name = $response->Response->bungieNetUser->displayName;
		}
		if (count($response->Response->destinyAccounts) == 0) {
			// No destiny account mean something went wrong (because we looked 
			// up the bungie account using a destiny account, so it must exist. DUH)
			$this->error = Error::show(Error::ERROR, "Destiny is in maintenance");
			return;
		}
		foreach ($response->Response->destinyAccounts as $account) {
			if ($account->userInfo->membershipType != $this->console && count($response->Response->destinyAccounts) == 1) {
				// This is a weird error. If you only played the Alpha or Beta on a console, 
				// but left to play the complete game on another console, this would show up.
				$this->error = Error::show(Error::WARNING, "Account found but played an earlier version of the game");
			}
			$this->add_account($account->userInfo->membershipType, json_decode(json_encode($account->userInfo), true));
		}
	}
	
	function fetch($console) {
		// This endpoint returns stats for every character created on the account
		$url = "https://www.bungie.net/Platform/Destiny/Stats/Account/" . $this->accounts[$console]['membershipType'] . "/" . $this->accounts[$console]['membershipId'];
		$lookup = file_get_contents($url);
		$response = json_decode($lookup);
		$time_played = $response->Response->mergedAllCharacters->merged->allTime->secondsPlayed->basic->value;
		$this->accounts[$console]['timePlayed'] = $time_played;
		$this->add_time($time_played);
	}
}

class Error {
	const SUCCESS = "Success";
	const WARNING = "Warning";
	const ERROR = "Error";
	
	static function show($error_type, $message) {
		return array("Status" => $error_type,
					 "Message" => $message,
					 "LoadTime" => 0,
					 "CacheTime" => 0);
	}
}

class Timer {
	private $time_running;
	private $exec_time;

	function __construct() {
		// Creating the timer starts it
		$this->reset_timer();
	}

	function reset_timer() {
		// Starts the timer
		$this->exec_time = microtime(true);
		$this->time_running = true;
	}

	function get_timer() {
		// Stops and saves the timer if it's started
		if ($this->time_running) {
			// Don't calculate again if the timer was already stopped
			$this->time_running = false;
			$this->exec_time = round(microtime(true) - $this->exec_time, 4);
		}
		// Shows the timer value
		return $this->exec_time;
	}
}