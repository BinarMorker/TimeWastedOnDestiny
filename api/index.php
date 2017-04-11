<?php

header("Access-Control-Allow-Origin: *");

// Autoloading of all needed classes
spl_autoload_register(function ($class_name) {
	include $_SERVER['DOCUMENT_ROOT'].'/api/classes/' . $class_name . '.php';
});

// Call the API
Api::request();