<?php

session_start();

require_once("../rabbitmq_required.php");
require_once("friends_functions.php");
require_once("beer_show.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$_SESSION['friends_id'] = htmlspecialchars($_POST['friends_id']);
$_SESSION['friends_username'] = htmlspecialchars($_POST['friends_username']);
$_SESSION['friends_firstname'] = htmlspecialchars($_POST['friends_firstname']);
$_SESSION['friends_lastname'] = htmlspecialchars($_POST['friends_lastname']);

require_once("../view/friends_profile.view.php");

?>