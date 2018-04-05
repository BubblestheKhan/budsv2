<?php

session_start();

require_once('../path.inc');
require_once('../get_host_info.inc');
require_once('../rabbitMQLib.inc');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());

$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

$search = htmlspecialchars($_POST['search']);
$_SESSION['search'] = $search;

if (!isset($username)) {
	header("Location: ../view/login.view.php");
	exit();
}

if (isset($_POST['logout'])) {
	session_destroy();
	
	$request['type'] = 'logout';
	$request['username'] = $username;
	$request['message'] = 'User has logged out';

	$response = $client->send_request($request);

	header("Location: ../view/login.view.php");
	exit();

}

if (isset($_SESSION['search'])){

	$request = array();
	$request['type'] = 'beerSearchAll';
	$request['beerSearchAll'] = $_SESSION['search'];
	$request['message'] = '{$username} searched for {$search}';

	$response = $client->send_request($request);

	header("Location: ../controller/search.php");
	exit();

}

require("../view/home.view.php");

?>