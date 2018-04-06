<?php

session_start();

require_once('../path.inc');
require_once('../get_host_info.inc');
require_once('../rabbitMQLib.inc');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());

$_SESSION['search'] = htmlspecialchars($_POST['search']);

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

if (isset($_POST['logout'])) {
	session_destroy();
	
	$request['type'] = 'logout';
	$request['username'] = $_SESSION['username'];
	$request['message'] = 'User has logged out';

	$response = $client->send_request($request);

	header("Location: login.php");
	exit();

}

if (!empty($_SESSION['search'])){

	header("Location: search.php");
	exit();

}

require("../view/home.view.php");

?>