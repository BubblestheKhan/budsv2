<?php 

require('../template/header.html');
require('../template/footer.html');

?>

<head>
	<link href="../css/home.css" rel="stylesheet" type="text/css">
</head> 

<div class="container">
	<div class="main-content">
		<div class="row">
			<div class="col-md-8 column1">
				<h2 class="search_title">Search Please?</h2>
				<form class="form-group" method="post" action="../controller/home.php">
					<input class="form-control form-control-lg" type="text" placeholder="What will you be searching for today?" name="search">
				</form>
			</div>
			<div class="col-md-4 column2">
				<div class="profile">
					<h1><span id="username"><?php echo $_SESSION['friends_username']; ?></span></h1>
					<span class="name"><?php echo $_SESSION['friends_firstname'] . ' ' .$_SESSION['friends_lastname']; ?></span>

					<!--Log Out-->
					<form method="post" action="../controller/home.php">
						<input type="submit" class="logout btn btn-outline-danger btn-sm" name='logout' value="Log out">
					</form>
				</div>
			</div>
		</div>
		<?php if (empty(friends_show($_POST['friends_id']))) : ?>
			<div class="row justify-content-md-end">
				<div class="col-md-4 column2 friends-list">
					<h2><span id="friends">Friends List</span></h2>
					<h3>User has no friends...</h3>
				</div>
			</div>
		<?php else: ?>
			<div class="row justify-content-md-end">
				<div class="col-md-4 column2 friends-list">
					<h2><span id="friends">Friends List</span></h2>
					<?php foreach (friends_show($_POST['friends_id']) as $friend => $name) : ?>				
						<div class="row">
							<div class="col-md-6 friends-name">
								<form method="POST" action="../controller/home.php">
									<input type="hidden" name="friends_id" value="<?php echo $name['id']; ?>">
									<button type="submit" class="btn btn-outline-success" role="button" value="friends_name"><?php echo $name['username']; ?></button>
								</form>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
			<div class="row justify-content-md-end">
				<div class="col-md-4 column2 user-search">
					<form class="form-group" method="POST" action="../controller/home.php">
						<input class="form-control form-control-lg" type="text" placeholder="Search for people" name="user_search">
						<input class="btn btn-default my-2 my-sm-2" type="submit" value="Search">
					</form>
				</div>
			</div>
		<?php if (empty(beer_show($_SESSION['friends_id']))) : ?>
			<div class="row justify-content-md-end">
				<div class="col-md-4 column2 favorite-list">
					<h2><span id="favorite">Favorite List</span></h2>			
					<h3>User doesn't like beers.....</h3>
				</div>
			</div>
		<?php else : ?>
			<div class="row justify-content-md-end">
				<div class="col-md-4 column2 favorite-list">
					<h2><span id="favorite">Favorite List</span></h2>
					<?php foreach (beer_show($_SESSION['friends_id']) as $beers => $name) : ?>	
						<form method="POST" action="../controller/home.php">
							<input type="hidden" name="beer_name" value="<?php echo $name['beer_name']; ?>">
							<button type="submit" class="btn btn-outline-success" role="button"><?php echo $name['beer_name']; ?></button>
						</form>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
