<?php

require_once('../rabbitmq_required.php');

function activity_add($username, $activity, $object) {

	$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

	$request = array();
	$request['type'] = "activity_add";
	$request['user_name'] = $username;
	$request['activity'] = $activity;
	$request['object'] = $object;

	$response = $client->send_request($request);

	return;

}

?>