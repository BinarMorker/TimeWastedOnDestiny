<?php

/**
 * A simple timer
 * @author François Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class Timer {

	/**
	 * The current instance for the timer object
	 * @var Timer
	 */
	private static $instance;

	/**
	 * Is the time still running?
	 * @var boolean
	 */
	private $time_running;

	/**
	 * Total time the script has been running
	 * @var int
	 */
	private $exec_time;

	private function __construct() {
		
	}

	/**
	 * Get the timer instance or create it
	 * @return The instance
	 */
	private static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new static();
		}
		
		return self::$instance;
	}

	/**
	 * Stop the timer and set it to 0
	 */
	public static function reset() {
		self::getInstance()->time_running = false;
		self::getInstance()->exec_time = 0;
	}

	/**
	 * Start the timer with the current computer time as value
	 */
	public static function start() {
		self::getInstance()->exec_time = microtime(true);
		self::getInstance()->time_running = true;
	}

	/**
	 * Stop and get time timer value
	 * @return The time counted from the start
	 */
	public static function stop() {
		if (self::getInstance()->time_running) {
			// Don't calculate again if the timer was already stopped
			self::getInstance()->time_running = false;
			self::getInstance()->exec_time = round(
				microtime(true) - self::getInstance()->exec_time, 
				4
			);
		}
		
		return self::getInstance()->exec_time;
	}
}