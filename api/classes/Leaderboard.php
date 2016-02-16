<?php

/**
 * Leaderboard interface with database wrapper
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class Leaderboard {
	
	/**
	 * The database object
	 * @var PDO
	 */
	private $database;
	
	/**
	 * The current instance for the leaderboard object
	 * @var Leaderboard
	 */
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
	
	/**
	 * Get the leaderboard instance or create it
	 * @return The instance
	 */
	private static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new static();
		}
		
		return self::$instance;
	}
	
	/**
	 * Get the player rank
	 * @param string $membershipId
	 * @return The rank or false if an error occurs
	 */
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

	/**
	 * Verify if the player is new to the leaderboard
	 * @param string $membershipId
	 * @return True if the player is new
	 */
	public static function isNew($membershipId) {
		$query = 'SELECT * FROM leaderboard WHERE `id`=:id;';
		$statement = self::getInstance()->database->prepare($query);
		$statement->execute(array(
			':id' => $membershipId
		));
		return $statement->fetch() ? false : true;
	}

	/**
	 * Get last ten players from the leaderboard
	 * @return An array of the ten players
	 */
	public static function getLastTen() {
		$query = "SELECT * FROM leaderboard ORDER BY `seconds` DESC LIMIT 10;";
		$statement = self::getInstance()->database->prepare($query);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Get the total number of entries in the leaderboard
	 * @return The number of players
	 */
	public static function getTotalPlayers() {
		$query = "SELECT COUNT(*) as `count` FROM leaderboard;";
		$statement = self::getInstance()->database->prepare($query);
		$statement->execute();
		
		if ($count = $statement->fetch()) {
			return $count[0];
		}
		
		return false;
	}

	/**
	 * Add a player to the leaderboard
	 * @param int $membershipType The console identifier
	 * @param string $membershipId The player identifier
	 * @param string $displayName The display name
	 * @param int $timePlayed Total time played
	 * @return True if the query succeeded
	 */
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