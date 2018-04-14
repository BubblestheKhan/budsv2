<?php

session_start();

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$_SESSION['beer'] = str_replace("'", "\'", htmlspecialchars($_GET['beer_name']));

$request = array();
$request['type'] = 'beer_rate_average';
$request['beer_name'] = $_SESSION['beer'];
$request['message'] = "Searching for the specific Beer";

$rate_average = $client->send_request($request);



?>