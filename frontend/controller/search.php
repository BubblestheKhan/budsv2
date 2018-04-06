<?php

session_start();

require_once('../path.inc');
require_once('../get_host_info.inc');
require_once('../rabbitMQLib.inc');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$date = date("Y-m-d");
$time = date("h:m:sa");

$_SESSION['beer'] = htmlspecialchars($_GET['beer']);
$_SESSION['venue'] = htmlspecialchars($_GET['venue']);


if (!empty($_SESSION['venue'])) {

	$request = array();
	$request['type'] = 'venue_search_all';
	$request['venue_all'] = urlencode($_SESSION['venue']);
	$request['message'] = '{$username} searched for {$search}';

	$response = $client->send_request($request);

	require('../view/search.view.php');

} elseif (isset($_SESSION['search']) || !empty($_SESSION['beer'])) {

	$request = array();
	$request['type'] = 'beer_search_all';
	$request['beer_all'] = urlencode($_SESSION['search']);
	$request['message'] = '{$username} searched for {$search}';

	$response = $client->send_request($request);

	require('../view/search.view.php');

} else {

	require("../view/search.view.php");

}

?>

