<?php

require_once('database.php');

class DatabaseQuery {

	protected $pdo;

	public function __construct($pdo) {

		$this->pdo = $pdo;

	}

	public function login($username, $password) {

		$date = date("Y-m-d");
		$time = date("h:m:sa");

		$statement = $this->pdo->prepare("SELECT username, password FROM users WHERE username = '{$username}'");
		$statement->execute();

		$result = $statement->fetchAll();
		var_dump($result);

		if (!empty($result)) {

			if (password_verify($password, $result[0]["password"])) {

				$code = "202";
				$log = "$date $time Response Code {$code}: Username {$username} Authorized!";

				$response = $this->pdo->prepare("SELECT username, firstname, lastname FROM users WHERE username = '{$username}'");
				$response->execute();

				$result = $response->fetchAll();
				file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);
				var_dump($result);

				return $result;
			
			} else {

				$code = '401';
				$log = "$date $time Response Code '{$code}': Username $username, Unauthorized Access.";
				file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

				return $code;

			}
		
		} elseif (empty($username) || empty($password)) {

			$code = '428';
			$log = "$date $time Response Code '{$code}': Empty fields requested.";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			return $code;

		} else {

			$code = "404";
			$log = "$date $time Response Code '{$code}': Username not found.";

			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);
			return $code;
			
		
		}


	}

	public function logout($username) {

		$date = date("Y-m-d");
		$time = date("h:m:sa");

		$log = "$date, $time: User'{$username}' has logged out";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

	}

	public function register($username, $password, $firstname, $lastname) {

		$date = date("Y-m-d");
		$time = date("h:m:sa");
		$options = ['length' => 11];
		$hash = password_hash($password, PASSWORD_DEFAULT, $options);

		$statement = $this->pdo->prepare("SELECT username FROM users where username = '{$username}'");
		$statement->execute();

		$result = $statement->fetchAll();

		if (!empty($result)) {
			$code = "302";
			$log = "$date $time Response Code '{$code}': Username $username already registered.";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			return $code;

		} else {

			$statement = $this->pdo->prepare("INSERT INTO users (username, password, firstname, lastname) VALUES (:username, :password, :firstname, :lastname)");

			$statement->bindParam(":username", $username);
			$statement->bindParam(":password", $hash);
			$statement->bindParam(":firstname", $firstname);
			$statement->bindParam(":lastname", $lastname);

			$statement->execute();

			$code = "201";
			$log = "$date $time Response Code '{$code}': Username $username successfully registered to the database.";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			return $code;

		}
	}
}

?>