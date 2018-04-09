<?php

session_start();

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$date = date("Y-m-d");
$time = date("h:m:sa");

$_SESSION['beer'] = htmlspecialchars($_POST['beer_search']);
$_SESSION['venue'] = htmlspecialchars($_POST['venue_search']);

if (!empty($_SESSION['venue'])) {

	$request = array();
	$request['type'] = 'venue_search_all';
	$request['venue_all'] = urlencode($_SESSION['beer_name']);
	$request['message'] = '{$username} searched for {$search}';

	$response = $client->send_request($request);

	require('../view/search.view.php');

} elseif (!empty($_SESSION['beer_name'])) {

	$request = array();
	$request['type'] = 'beer_search_all';
	$request['beer_all'] = urlencode($_SESSION['beer_name']);
	$request['message'] = '{$username} searched for {$search}';

	$response = $client->send_request($request);

	require("../view/search.view.php");

} elseif (!empty($_SESSION['search'])) {

	$request = array();
	$request['type'] = 'beer_search_all';
	$request['beer_all'] = urlencode($_SESSION['search']);
	$request['message'] = '{$username} searched for {$search}';

	$response = $client->send_request($request);

	require('../view/search.view.php');
}

?>

