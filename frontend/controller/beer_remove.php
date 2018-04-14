<?php

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$_SESSION['beer_remove'] = htmlspecialchars($_POST['beer_remove']);
$_SESSION['id'] = htmlspecialchars($_POST['id']);

$request = array();
$request['type'] = 'beer_remove';
$request['id'] = $_SESSION['id'];
$request['beer_name'] = $_SESSION['beer_remove'];
$request['message'] = "Remove the beer from the favorite list";

$beer_remove = $client->send_request($request);

header("Location: home.php");
exit();



?>