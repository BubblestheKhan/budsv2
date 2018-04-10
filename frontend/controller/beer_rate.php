<?php

session_start();

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$rate = htmlspecialchars($_POST['rate']);

if (!empty($_SESSION['id'])) {

	$request = array();
	$request['type'] = 'beer_rate';
	$request['user_id'] = $_SESSION['id'];
	$request['beer_name'] = $_SESSION['beer'];
	$request['rate'] = (floatval($rate));
	$request['message'] = "{$_SESSION['username']} has rated {$_SESSION['beer']}";

	$rate = $client->send_request($request);

	header("Location: home.php");
	exit();

}

?>