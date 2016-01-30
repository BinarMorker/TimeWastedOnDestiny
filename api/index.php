<?php

$help = <<<EOT
Time Wasted on Destiny API v1.8
===============================

HELP:
-----
To see this page again, remove everything after "api"
or add the "help" parameter

SYNTAX:
-------
api?help
api?version
api?console=2&user=binarmorker
api?console=2&user=binarmorker&fmt
api?leaderboard

PARAMETERS:
-----------
console=[_] : 1 for xbox, 2 for playstation
user=[_]    : Your xbox or playstation username
fmt         : Shows a structured JSON array
help        : Show this page regardless of the other parameters
version     : Show the current and latest API version
leaderboard : Show the leaderboard data

CACHE:
------
Each request is saved on the server for a period of 1 hour
Every subsequent call within the hour will return the same data

CREDIT:
-------
Created by François Allard
Please give credit if you use this!
EOT;

spl_autoload_register(function ($class_name) {
	include 'classes/' . $class_name . '.php';
});

Api::request($help);