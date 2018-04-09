<?php

session_start();

require_once("../rabbitmq_required.php");
require_once("friends_functions.php");
require_once("beer_show.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$_SESSION['search'] = htmlspecialchars($_POST['search']);
$_SESSION['user_search'] = htmlspecialchars($_POST['user_search']);
$_SESSION['beer_name'] = htmlspecialchars($_POST['beer_name']);

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

if (isset($_POST['logout'])) {
	session_destroy();
	
	$request['type'] = 'logout';
	$request['username'] = urlencode($_SESSION['username']);
	$request['message'] = 'User has logged out';

	$response = $client->send_request($request);

	header("Location: login.php");
	exit();

}

if (!empty($_SESSION['search']) || !empty($_SESSION['beer_name'])){

	header("Location: search.php");
	exit();

}

if (!empty($_SESSION['user_search'])) {

	header("Location: user_search.php");
	exit();

}

require("../view/home.view.php");

?>