<?php

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$request = array();
$request['type'] = 'friends_show';
$request['friends_show'] = $_SESSION['id'];
$request['message'] = "Show the users friends list";

$friends_show = $client->send_request($request);
var_dump($friends_show);

?>