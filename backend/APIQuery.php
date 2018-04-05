<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

class APIQuery {

	public function beerSearchAll($search) {

		$date = date("Y-m-d");
		$time = date("h:m:sa");

		$log = "{$date}, {$time}: Searching from the API...";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		$client = new rabbitMQClient("testRabbitMQ.ini", "Backend");

		$request = array();
		$request['type'] = "beerSearchAll";
		$request['beerSearchAll'] = $search;
		$request['message'] = 'API Search for all the beers';

		$api_request = $client->send_request($request);

		var_dump($api_request);
		return $api_request;

	}
}