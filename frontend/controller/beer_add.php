<?php

session_start();

require_once('../rabbitmq_required.php');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$beer = htmlspecialchars($_POST['beer_name']);

if (!empty($_SESSION['id'])) {

	$request = array();
	$request['type'] = 'beer_favorite';
	$request['id'] = $_SESSION['id'];
	$request['firstname'] = $_SESSION['firstname'];
	$request['beer_name'] = $beer;
	$request['message'] = "'{$_SESSION['username']} favorited beer '{$beer}'";

	$friend_request = $client->send_request($request);

	header("Location: home.php");
	exit();
}

?>