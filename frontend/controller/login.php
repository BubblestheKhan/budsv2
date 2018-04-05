<?php

session_start();

require_once('../path.inc');
require_once('../get_host_info.inc');
require_once('../rabbitMQLib.inc');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());


$_SESSION['username'] = htmlspecialchars($_POST['username']);
$password =  htmlspecialchars($_POST['password']);
$error = '';

if (isset($_POST['register'])) {

	header("Location: ../view/registration.view.php");


} elseif (isset($_POST['login'])) {


	$request = array();
	$request['type'] = "login";
	$request['username'] = $_SESSION['username'];
	$request['password'] = $password;
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

		header("Location: ../view/home.view.php");
		exit();

	}
}


?>
