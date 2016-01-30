<?php

/**
 * Create and manage a system timer.
 * The Timer can be used to calculate the script execution time.
 */
class Timer {
	
	private static $instance;

	/** @var boolean True if the timer is still counting */
	private $time_running;

	/** @var int Total time the script has been running */
	private $exec_time;

	/**
	 * Create the timer.
	 * The timer object, once being created, sets itself to 0.
	 */
	private function __construct() {
		
	}
	
	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new static();
		}
		
		return self::$instance;
	}

	/**
	 * Reset the timer.
	 * The timer stops itself and sets itself to 0.
	 */
	public static function reset() {
		self::getInstance()->time_running = false;
		self::getInstance()->exec_time = 0;
	}

	/**
	 * Start the timer.
	 * The timer starts with the current computer time as value.
	 */
	public static function start() {
		// Starts the timer
		self::getInstance()->exec_time = microtime(true);
		self::getInstance()->time_running = true;
	}

	/**
	 * Stop and get time timer value.
	 * The timer is stopped and its value is calculated returned.
	 *
	 * @return int The time counted from the start
	 */
	public static function stop() {
		// Stops and saves the timer if it's started
		if (self::getInstance()->time_running) {
			// Don't calculate again if the timer was already stopped
			self::getInstance()->time_running = false;
			self::getInstance()->exec_time = round(
				microtime(true) - self::getInstance()->exec_time, 
				4
			);
		}
		// Shows the timer value
		return self::getInstance()->exec_time;
	}
}