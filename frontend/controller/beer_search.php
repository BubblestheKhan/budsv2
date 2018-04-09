<?php

session_start();

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$_SESSION['beer'] = htmlspecialchars($_GET['beer_name']);

$request = array();
$request['type'] = 'beer_search_name';
$request['beer_name'] = urlencode($_SESSION['beer']);
$request['message'] = "Searching for the specific Beer";

$response = $client->send_request($request);

require '../view/beer_search.view.php';


?>
