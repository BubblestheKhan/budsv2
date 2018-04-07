<?php

require_once('../rabbitmq_required.php');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$_SESSION['user_id'] = htmlspecialchars($_POST['friend_name']);

if (!empty($_SESSION['user_id'])) {

	$request = array();
	$request['type'] = 'user_add';
	$request['user_id'] = $_SESSION['user_id'];
	$request['message'] = "'{$_SESSION['username']} made a friend request to '{$_SESSION['user_id']}'";

	$friend_request = $client->send_request($request['user_id']);

}

?>