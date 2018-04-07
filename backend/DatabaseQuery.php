<?php

require_once('database.php');

class DatabaseQuery {

	protected $pdo;

	public function __construct($pdo) {

		$this->pdo = $pdo;
		$this->date = date('Y-m-d');
		$this->time = date('h:m:sa');

	}

	public function login($username, $password) {

		$statement = $this->pdo->prepare("SELECT username, password FROM users WHERE username = '{$username}'");
		$statement->execute();

		$result = $statement->fetchAll();
		var_dump($result);

		if (!empty($result)) {

			if (password_verify($password, $result[0]["password"])) {

				$code = "202";
				$log = "{$this->date}, {$this->time}: Response Code {$code}: Username {$username} Authorized!";
				file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

				$response = $this->pdo->prepare("SELECT id, username, firstname, lastname FROM users WHERE username = '{$username}'");
				$response->execute();

				$result = $response->fetchAll();
				
				var_dump($result);

				return $result;
			
			} else {

				$code = '401';
				$log = "{$this->date}, {$this->time}: Response Code '{$code}': Username $username, Unauthorized Access.";
				file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

				return $code;

			}
		
		} elseif (empty($username) || empty($password)) {

			$code = '428';
			$log = "{$this->date}, {$this->time}: Response Code '{$code}': Empty fields requested.";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			return $code;

		} else {

			$code = "404";
			$log = "{$this->date}, {$this->time}: Response Code '{$code}': Username not found.";

			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);
			return $code;
			
		
		}


	}

	public function logout($username) {

		$log = "{$this->date}, {$this->time}: User'{$username}' has logged out";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

	}

	public function register($username, $password, $firstname, $lastname) {

		$options = ['length' => 11];
		$hash = password_hash($password, PASSWORD_DEFAULT, $options);

		$statement = $this->pdo->prepare("SELECT username FROM users where username = '{$username}'");
		$statement->execute();

		$result = $statement->fetchAll();

		if (!empty($result)) {
			$code = "302";
			$log = "{$this->date}, {$this->time}: Response Code '{$code}': Username $username already registered.";
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
			$log = "{$this->date}, {$this->time}: Response Code '{$code}': Username $username successfully registered to the database.";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			return $code;

		}
	}

	public function user_add($user_from, $user_to, $status) {
		var_dump($user_to);

		$statement = $this->pdo->prepare("INSERT INTO friends_request (user_from, user_to, status) VALUES (:user_from, :user_to, :status)");

		$statement->bindParam(":user_from", $user_from);
		$statement->bindParam(":user_to", $user_to);
		$statement->bindParam(":status", $status);

		$statement->execute();
		
	}

	public function user_search($user_search) {

		$statement = $this->pdo->prepare("SELECT id, username, firstname, lastname FROM users WHERE username = '{$user_search}' OR firstname = '{$user_search}'");
		$statement->execute();

		$result = $statement->fetchAll();

		var_dump($result);
		return $result;

	}
}

?>