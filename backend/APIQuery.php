<?php

require_once("rabbitmq_required.php");

class APIQuery {

	public function __construct() {

		$this->date = date('Y-m-d');
		$this->time = date('h:m:sa');
	
	}

	public function beer_search_all($search) {

		$log = "{$this->date}, {$this->time}: Searching beers from the API.";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		$client = new rabbitMQClient("testRabbitMQ.ini", "Backend");

		$request = array();
		$request['type'] = "beer_search_all";
		$request['beer_all'] = $search;
		$request['message'] = 'API search for all the beers';

		$api_request = $client->send_request($request);

		var_dump($api_request);
		return $api_request;

	}

	public function beer_search_name($search) {

		$log = "{$this->date}, {$this->time}: Searching the beer from the API.";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		$client = new rabbitMQClient("testRabbitMQ.ini", "Backend");

		$request = array();
		$request['type'] = "beer_search_name";
		$request['beer_name'] = $search;
		$request['message'] = 'API search for the beer';

		$api_request = $client->send_request($request);

		var_dump($api_request);
		return $api_request;


	}

	public function location_search($search) {

		$log = "{$this->date}, {$this->time}: Searching for the address from the API.";

		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		$client = new rabbitMQClient("testRabbitMQ.ini", "Backend");

		$request = array();
		$request['type'] = "location_search";
		$request['location_search'] = $search;
		$request['message'] = "API search for the location of the venue";

		$response = $client->send_request($request);

		var_dump($response);
		return $response;


	}

	public function venue_search_all($search) {

		$log = "{$this->date}, {$this->time}: Searching venues from the API...";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		$client = new rabbitMQClient("testRabbitMQ.ini", "Backend");

		$request = array();
		$request['type'] = "venue_search_all";
		$request['venue_all'] = $search;
		$request['message'] = 'API search for all the venues';

		$api_request = $client->send_request($request);

		var_dump($api_request);
		return $api_request;
		
	}

	public function venue_search_id($search) {

		$log = "{$this->date}, {$this->time}: Searching the beer from the API.";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		$client = new rabbitMQClient("testRabbitMQ.ini", "Backend");

		$request = array();
		$request['type'] = "venue_search_id";
		$request['venue_id'] = $search;
		$request['message'] = 'API search for the venue';

		$api_request = $client->send_request($request);

		var_dump($api_request);
		return $api_request;

	}
}