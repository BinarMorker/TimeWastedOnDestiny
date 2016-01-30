<?php

class Leaderboard {
	
	private $database;
	private static $instance;
	
	private function __construct() {
		$host = Config::get('databaseHost');
		$database = Config::get('databaseName');
		$username = Config::get('databaseUsername');
		$password = Config::get('databasePassword');
		$this->database = new PDO(
			"mysql:host=$host;dbname=$database;charset=utf8", 
			$username, 
			$password
		);
	}
	
	private static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new static();
		}
		
		return self::$instance;
	}
	
	public static function getPlayerRank($membershipId) {
		$query = 'SELECT * '.
				 'FROM (SELECT @rownum:=@rownum+1 `rank`, `id` '.
				 'FROM leaderboard, (SELECT @rownum:=0) r ORDER BY `seconds` DESC) '.
				 'AS `ranks` WHERE `id`=:id;';
		$statement = self::getInstance()->database->prepare($query);
		$statement->execute(array(
			':id' => $membershipId
		));
		
		if ($player = $statement->fetch()) {
			return $player['rank'];
		}
		
		return false;
	}
	
	public static function isNew($membershipId) {
		$query = 'SELECT * FROM leaderboard WHERE `id`=:id;';
		$statement = self::getInstance()->database->prepare($query);
		$statement->execute(array(
			':id' => $membershipId
		));
		return $statement->fetch() ? false : true;
	}
	
	public static function getLastTen() {
		$query = "SELECT * FROM leaderboard ORDER BY `seconds` DESC LIMIT 10;";
		$statement = self::getInstance()->database->prepare($query);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function getTotalPlayers() {
		$query = "SELECT COUNT(*) as `count` FROM leaderboard;";
		$statement = self::getInstance()->database->prepare($query);
		$statement->execute();
		
		if ($count = $statement->fetch()) {
			return $count[0];
		}
		
		return false;
	}
	
	public static function addPlayer($membershipType, $membershipId, $displayName, $timePlayed) {
		$query = 'REPLACE INTO leaderboard '.
				 '(`console`, `id`, `username`, `seconds`) '.
				 'VALUES (:console, :id, :username, :seconds);';
		$statement = self::getInstance()->database->prepare($query);
		return $statement->execute(array(
			':console' => $membershipType - 1,
			':id' => $membershipId,
			':username' => $displayName,
			':seconds' => $timePlayed
		));
	}
	
}