<?php
if (isset($_GET['help']) || !isset($_GET['user']) || !isset($_GET['console']) || empty($_GET['user']) || empty($_GET['console'])) {
	header("Content-Type: text/plain");
	echo file_get_contents("help.txt");
	die;
}

header("Content-Type: application/json");

$input_name = $_GET['user'];
$input_console = $_GET['console'];

try {
	$response = array();
	$account = new DestinyAccount($input_name, $input_console);
	$account->lookup();
	$account->get_accounts();
	$response["displayName"] = $account->display_name;
	if (array_key_exists(1, $account->accounts)) {
		$account->fetch(1);
		$xbl_time = $account->accounts[1];
		$response["xbox"] = $xbl_time;
	}
	if (array_key_exists(2, $account->accounts)) {
		$account->fetch(2);
		$psn_time = $account->accounts[2];
		$response["playstation"] = $psn_time;
	}
	$response["totalTime"] = $account->total_time;
	echo json_encode(array("Response" => $response, "Error" => $account->error));
	die;
} catch (Exception $e) {
	echo json_encode(array("Response" => "", "Error" => $account->error));
	die;
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
		$url = "https://www.bungie.net/platform/destiny/SearchDestinyPlayer/" . $this->console . "/" . $this->name;
		$lookup = file_get_contents($url);
		$response = json_decode($lookup);
		if ($response->ErrorCode == 5) {
			$this->error = Error::show(Error::ERROR, "Destiny is in maintenance");
			throw(new Exception());
		}
		if (!empty($response->Response)) {
			if (!$retry) {
				$this->error = Error::show(Error::SUCCESS, "Player found");
			} else {
				$this->error = Error::show(Error::WARNING, "Account found on another platform");
			}
			$this->temp_account_id = $response->Response[0]->membershipId;
		} else {
			if (!$retry) {
				$this->swap_console();
				$this->lookup(true);
			} else {
				$this->error = Error::show(Error::ERROR, "Account not found");
				throw(new Exception());
			}
		}
	}
	
	function swap_console() {
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
		$url = "https://www.bungie.net/platform/user/GetBungieAccount/" . $this->temp_account_id . "/" . $this->console;
		$lookup = file_get_contents($url);
		$response = json_decode($lookup);
		if (isset($response->Response->bungieNetUser)) {
			$this->display_name = $response->Response->bungieNetUser->displayName;
		}
		if (count($response->Response->destinyAccounts) == 0) {
			$this->error = Error::show(Error::ERROR, "Destiny is in maintenance");
			return;
		}
		foreach ($response->Response->destinyAccounts as $account) {
			if ($account->userInfo->membershipType != $this->console && count($response->Response->destinyAccounts) == 1) {
				$this->error = Error::show(Error::WARNING, "Account found but played an earlier version of the game");
			}
			$this->add_account($account->userInfo->membershipType, json_decode(json_encode($account->userInfo), true));
		}
	}
	
	function fetch($console) {
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
		return array($error_type => $message);
	}
	
}