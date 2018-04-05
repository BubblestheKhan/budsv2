<?php

require_once('../path.inc');
require_once('../get_host_info.inc');
require_once('../rabbitMQLib.inc');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$date = date("Y-m-d", time());

$username = 'tariq';//htmlspecialchars($_POST['username']);
$password = 'password';//htmlspecialchars($_POST['password']);
$confirmPassword = 'password';//htmlspecialchars($_POST['confirmPassword']);
$firstname = 'tariq';//htmlspecialchars($_POST['firstname']);
$lastname = 'khan';//htmlspecialchars($_POST['lastname']);

$missingError = '';
$validateError = '';

if (isset($_POST['register'])) {

	if ((empty($username)) or ((empty($password))) or ((empty($firstname))) or ((empty($lastname)))) {
		$missingError = "Oops! You are missing some fields."; 
	
		if ($confirmPassword != $password) {
			$validateError = "Oops! Password did not match.";

		}

		header("Location: ../view/registration.view.php");
	
	}  else {

		$request = array();
		$request['type'] = "register";
		$request['username'] = $username;
		$request['password'] = $password;
		$request['firstname'] = $firstname;
		$request['lastname'] = $lastname;
		$request['message'] = "'{$username}' has been registered '{$date}'";

		$response = $client->send_request($request);

		header("Location: ../view/login.view.php");
		exit();
		
	}
} 
	




?>

