<?php

require_once("../rabbitmq_required.php");

function friends_show($id) {

	$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");
	
	$request = array();
	$request['type'] = 'friends_show';
	$request['friends_show'] = $id;
	$request['message'] = "Show the users friends list";

	$friends_show = $client->send_request($request);

	return $friends_show;

}

?>