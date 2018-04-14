<?php

require_once('database.php');

class DatabaseQuery {

	protected $pdo;

	public function __construct($pdo) {

		$this->pdo = $pdo;
		$this->date = date('Y-m-d');
		$this->time = date('h:m:sa');

	}

	public function activity_add($firstname, $activity, $object) {

		$statement = $this->pdo->prepare("INSERT INTO activity_news (user_name, activity, object) VALUES (:user_name, :activity, :object)");
		
		$statement->bindParam(":user_name", $firstname);
		$statement->bindParam(":activity", $activity);
		$statement->bindParam(":object", $object);
		$statement->execute();


	}

	public function activity_show() {

		$statement = $this->pdo->prepare("SELECT user_name, activity, object FROM activity_news");
		$statement->execute();

		$result = $statement->fetchAll();

		return $result;
	}

	public function beer_add($user_id, $beer_name) {

		$statement = $this->pdo->prepare("SELECT user_id, beer_name FROM beer_list WHERE user_id = '{$user_id}' AND beer_name = '{$beer_name}'");
		$statement->execute();
		$result = $statement->fetchAll();

		if (!empty($result)) {
			$log = "{$this->date}, {$this->time}: Beer '{$beer_name}', already exists!";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		} else {

			$log = "{$this->date}, {$this->time}: User '{$user_id}' has successfully added '{$beer_name}'";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			$statement = $this->pdo->prepare("INSERT INTO beer_list (user_id, beer_name) VALUES (:user_id, :beer_name)");

			$statement->bindParam(":user_id", $user_id);
			$statement->bindParam(":beer_name", $beer_name);
			$statement->execute();

		}

	}

	public function beer_favorite($user_id, $beer_name, $firstname) {

		$activity = " has favorited ";

		$statement = $this->pdo->prepare("SELECT user_id, beer_name FROM beer_list WHERE user_id = '{$user_id}' AND beer_name = '{$beer_name}'");
		$statement->execute();
		$result = $statement->fetchAll();

		if (!empty($result)) {
			$log = "{$this->date}, {$this->time}: Beer '{$beer_name}', already exists!'";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		} else {

			$log = "{$this->date}, {$this->time}: User '{$user_id}' has successfully added '{$beer_name}'";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			$statement = $this->pdo->prepare("INSERT INTO beer_list (user_id, beer_name) VALUES (:user_id, :beer_name)");

			$statement->bindParam(":user_id", $user_from);
			$statement->bindParam(":beer_name", $beer_name);
			$statement->execute();

			$statement = $this->pdo->prepare("INSERT INTO activity_news (user_name, activity, object) VALUES (:user_name, :activity, :object)");
		
			$statement->bindParam(":user_name", $firstname);
			$statement->bindParam(":activity", $activity);
			$statement->bindParam(":object", $beer_name);
			$statement->execute();

		}

	}

	public function beer_rate($user_id, $firstname, $beer_name, $rate) {

		$activity = " has rated '{$rate}' for ";

		$log = "{$this->date}, {$this->time}: User '{$user_id}' has given '{$rate}' to '{$beer_name}'";
		file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

		$statement = $this->pdo->prepare("INSERT INTO rating (user_id, beer_name, rate) VALUES (:user_id, :beer_name, :rate)");

		$statement->bindParam(":user_id", $user_id);
		$statement->bindParam(":beer_name", $beer_name);
		$statement->bindParam(":rate", $rate);
		$statement->execute();

		$statement = $this->pdo->prepare("INSERT INTO activity_news (user_name, activity, object) VALUES (:user_name, :activity, :object)");
		
		$statement->bindParam(":user_name", $firstname);
		$statement->bindParam(":activity", $activity);
		$statement->bindParam(":object", $beer_name);
		$statement->execute();

	}

	public function beer_rate_average($beer_name) {

		$statement = $this->pdo->prepare("SELECT AVG(rate) FROM rating  WHERE beer_name = '{$beer_name}'");
		$statement->execute();

		$result = $statement->fetchAll();

		return $result;

	}

	public function beer_remove($id, $beer_name) {

		$statement = $this->pdo->prepare("DELETE FROM beer_list WHERE user_id = '{$id}' AND beer_name = '{$beer_name}'");
		$statement->execute();

	}

	public function beer_show($user_id) {

		$statement = $this->pdo->prepare("SELECT beer_name FROM users u INNER JOIN beer_list b ON b.user_id = u.id WHERE b.user_id = '{$user_id}'");
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	}

	public function friend_add($user_from, $firstname, $user_to, $friends_name) {

		$statement = $this->pdo->prepare("SELECT user_id, friend_id FROM friends_list WHERE user_id = '{$user_from}' AND friend_id = '{$user_to}'");
		$statement->execute();
		$result = $statement->fetchAll();

		if (!empty($result)) {
			$log = "{$this->date}, {$this->time}: User '{$user_to}', already exists!";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);


			$code = "302";

			return $code;

		} else {

			$log = "{$this->date}, {$this->time}: User '{$user_from}' has successfully added '{$user_to}'";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			$activity = " has become friends with ";

			$statement = $this->pdo->prepare("INSERT INTO friends_list (user_id, friend_id) VALUES (:user_id, :friend_id)");

			$statement->bindParam(":user_id", $user_from);
			$statement->bindParam(":friend_id", $user_to);
			$statement->execute();

			$statement = $this->pdo->prepare("INSERT INTO friends_list (user_id, friend_id) VALUES (:user_id, :friend_id)");

			$statement->bindParam(":user_id", $user_to);
			$statement->bindParam(":friend_id", $user_from);
			$statement->execute();

			$code = "201";
			$log = "{$this->date}, {$this->time}: Response Code '{$code}': Friend $user_to successfully added to the database.";
			file_put_contents("log.txt", $log.PHP_EOL, FILE_APPEND | LOCK_EX);

			$statement = $this->pdo->prepare("INSERT INTO activity_news (user_name, activity, object) VALUES (:user_name, :activity, :object)");
			
			$statement->bindParam(":user_name", $firstname);
			$statement->bindParam(":activity", $activity);
			$statement->bindParam(":object", $friends_name);
			$statement->execute();


		}

	}

	public function friends_show($user_id) {

		$statement = $this->pdo->prepare("SELECT u.id, u.username, u.firstname, u.lastname FROM users u INNER JOIN friends_list f ON f.friend_id = u.id WHERE f.user_id = '{$user_id}'");
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
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

	public function user_search($user_search) {

		$statement = $this->pdo->prepare("SELECT id, username, firstname, lastname FROM users WHERE username = '{$user_search}' OR firstname = '{$user_search}'");
		$statement->execute();

		$result = $statement->fetchAll();

		return $result;

	}
}

?>