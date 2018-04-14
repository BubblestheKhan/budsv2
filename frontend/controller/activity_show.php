<?php

require_once('../rabbitmq_required.php');

function activity_show() {

	$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

	$request = array();
	$request['type'] = "activity_show";
	$activities = $client->send_request($request);

	return $activities;

}