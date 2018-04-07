<?php

session_start();

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$request = array();
$request['type'] = 'location_search';
$request['location_search'] = urlencode($_SESSION['venue_id']);
$request['message'] = "Searching for the address of the venue";

$location = $client->send_request($request);

?>

