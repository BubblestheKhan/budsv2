<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include('DatabaseQuery.php');
include('APIQuery.php');

function requestProcessor($request) {
	echo "Request received".PHP_EOL;
	$config = require('config.php');

	if(!isset($request['type'])) {
		return "Error: unsupported message type";
	}

	$apiquery = new APIQuery(); // Call the API class to query from the API
	$dbquery = new DatabaseQuery(Connection::connect($config['database'])); // Call the Database class to query from the DATABASE

	switch ($request['type']) {

		case "beerSearchAll":
			return $apiquery->beerSearchAll($request['beerSearchAll']);

		case "login":
			return $dbquery->login($request['username'], $request['password']);

		case "logout":
			return $dbquery->logout($request['username']);

		case "register":

			return $dbquery->register($request['username'], $request['password'], $request['firstname'], $request['lastname']);

		case "venueSearchAll":
			return $apiquery->venueSearchAll($request['venueSearchAll']);


	}

	return array("returnCode" => '0', 'message' => "Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini", "Frontend");
$server->process_requests('requestProcessor');

exit();

?>