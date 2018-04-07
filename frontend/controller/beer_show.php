<?php

require_once("../rabbitmq_required.php");

function beer_show($id) {

	$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");
	
	$request = array();
	$request['type'] = 'beer_show';
	$request['user_id'] = $id;
	$request['message'] = "Show the users beers list";

	$beer_show = $client->send_request($request);

	return $beer_show;

}

?>