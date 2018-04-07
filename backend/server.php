<?php

require_once("rabbitmq_required.php");
require_once('DatabaseQuery.php');
require_once('APIQuery.php');

function requestProcessor($request) {
	echo "Request received".PHP_EOL;
	$config = require('config.php');

	$date = date('Y-m-d');
	$time = date('h:m:sa');

	if(!isset($request['type'])) {
		return "Error: unsupported message type";
	}

	$apiquery = new APIQuery(); // Call the API class to query from the API

	try {

		$dbquery = new DatabaseQuery(Connection::connect($config['database'])); // Call the Database class to query from the DATABASE

		$log = "{$date}, {$time}: Successfully connected to the database.";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

	} catch (PDOException $e){

		$log = "{$date}, {$time}: Failed to connect to the database.";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

	}

	switch ($request['type']) {

		case "beer_search_name":
			return $apiquery->beer_search_name($request['beer_name']);

		case "beer_search_all":
			return $apiquery->beer_search_all($request['beer_all']);

		case "location_search":
			return $apiquery->location_search($request['location_search']);

		case "login":
			return $dbquery->login($request['username'], $request['password']);

		case "logout":
			return $dbquery->logout($request['username']);

		case "register":
			return $dbquery->register($request['username'], $request['password'], $request['firstname'], $request['lastname']);

		case "user_add":
			return $dbquery->user_add($request['id'], $request['user_id'], $request['status']);

		case "user_search":
			return $dbquery->user_search($request['user_search']);

		case "venue_search_id":
			return $apiquery->venue_search_id($request['venue_id']);

		case "venue_search_all":
			return $apiquery->venue_search_all($request['venue_all']);


	}

	return array("returnCode" => '0', 'message' => "Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini", "Frontend");
$server->process_requests('requestProcessor');

exit();

?>