<?php

session_start();

require_once("../rabbitmq_required.php");

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());


$username = htmlspecialchars($_POST['username']);
$password =  htmlspecialchars($_POST['password']);
$error = '';

if (isset($_POST['register'])) {

	header("Location: registration.php");
	exit();


} elseif (isset($_POST['login'])) {


	$request = array();
	$request['type'] = "login";
	$request['username'] = urlencode($username);
	$request['password'] = urlencode($password);
	$request['message'] = "'{$username}' requests to login '{$date}'";
	
	$response = $client->send_request($request);
	
	if ($response === '401') {

		$error = "Oops! Invalid Username/Password";

		require('../view/login.view.php');

	} elseif ($response === '404') {
		$error = "Oops! Username not found!";

		require('../view/login.view.php');
	
	} elseif ($response === '428') {

		$error = "Oops! Missing some fields!";

		require('../view/login.view.php');

	} else {

		$_SESSION['id'] = $response[0]['id'];
		$_SESSION['username'] = $response[0]['username'];
		$_SESSION['firstname'] = $response[0]['firstname'];
		$_SESSION['lastname'] = $response[0]['lastname'];

		header("Location: home.php");
		exit();

	}
}

require('../view/login.view.php');


?>
