<?php

session_start();

require_once('../rabbitmq_required.php');
require_once("activity_add.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$_SESSION['user_id'] = htmlspecialchars($_POST['user_id']);
$_SESSION['friends_first'] = htmlspecialchars($_POST['friends_first']);

if (!empty($_SESSION['user_id'])) {

	$request = array();
	$request['type'] = 'friend_add';
	$request['id'] = $_SESSION['id'];
	$request['firstname'] = $_SESSION['firstname'];
	$request['user_id'] = $_SESSION['user_id'];
	$request['friends_name'] = $_SESSION['friends_first'];
	$request['message'] = "'{$_SESSION['username']} made a friend request to '{$_SESSION['user_id']}'";

	$friend_request = $client->send_request($request);

	header("Location: home.php");
	exit();

}


?>