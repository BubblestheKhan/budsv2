<?php

require_once("../rabbitmq_required.php");

function friend_add($id) {

	$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

	$request = array();
	$request['type'] = 'friend_add';
	$request['id'] = $_SESSION['id'];
	$request['user_id'] = $_SESSION['user_id'];
	$request['message'] = "'{$_SESSION['username']} made a friend request to '{$_SESSION['user_id']}'";

	$friend_request = $client->send_request($request);

}

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