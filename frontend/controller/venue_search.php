<?php

session_start();

require_once("../rabbitmq_required.php");
require_once('location.php');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$_SESSION['venue_id'] = htmlspecialchars($_GET['venue_id']);

$request = array();
$request['type'] = 'venue_search_id';
$request['venue_id'] = urlencode($_SESSION['venue_id']);
$request['message'] = "Searching for the specific brewery";

$response = $client->send_request($request);

require_once('../view/venue_search.view.php');


?>
