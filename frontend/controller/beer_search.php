<?php

session_start();

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$beer_name = htmlspecialchars($_GET['beer_name']);
$_SESSION['beer_name'] = $beer_name;

$request = array();
$request['type'] = 'beer_search_name';
$request['beer_name'] = urlencode($_SESSION['beer_name']);
$request['message'] = "Searching for the specific Beer";

$response = $client->send_request($request);

require '../view/beer_search.view.php';


?>
