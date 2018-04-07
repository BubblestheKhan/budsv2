<?php

require_once("../template/header.html");
require_once("../template/footer.html");

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="container">
		<?php if (empty($response)) : ?>
			<div class="row">
				<div class="col-md-12 column1">
					<h2 id="errorSearch">Uh Oh... Could not find what you were searching for....</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 column2 user-search">
					<form class="form-inline-lg" method="post" action="../controller/home.php">
						<input class="form-control form-control-lg" type="text" placeholder="Search for people" name="user-search">
						<input class="btn btn-default my-5 my-md-4" type="submit" value="Search">
					</form>
				</div>
			</div>
		<?php else: ?>
			<?php foreach ($response as $key => $value) : ?>
			<div class="row">
				<div class="col-md-8 column1">
					<h2 id="username"><?php echo $value['username']; ?></h2>
					<p id="firstname"><?php echo $value['firstname']; ?></p>
					<p id="lastname"><?php echo $value['lastname']; ?></p>
					<form method="POST" action="../controller/friend_add.php">
						<input type="hidden" name="user_id" value="<?php echo $value['id']; ?>">
						<button type="submit" class="btn btn-outline-success" role="button" value="Add"><?php echo $status; ?></button>
					</form>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</body>
</html>