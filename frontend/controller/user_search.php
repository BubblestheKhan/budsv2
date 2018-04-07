<?php

session_start();

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$request = array();
$request['type'] = 'user_search';
$request['user_search'] = urlencode($_SESSION['user_search']);
$request['message'] = "Searching for users from the database";

$response = $client->send_request($request);

require_once("../view/users_search.view.php");


?>