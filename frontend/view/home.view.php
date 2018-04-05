<?php require('../template/header.html'); ?>
<?php require('../template/footer.html'); ?>

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
					<h1><span id="username"><?php echo $username; ?></span></h1>
					<span class="name"><?php echo $firstname . ' ' .$lastname; ?></span>

					<!--Log Out-->
					<form method="post" action="../controller/home.php">
						<input type="submit" class="logout btn btn-outline-danger btn-sm" name='logout' value="Log out">
					</form>
				</div>
			</div>
		</div>
		<?php if (empty($response)) : ?>
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
					<?php foreach ($response as $friend => $name) : ?>				
						<div class="row">
							<div class="col-md-6 friends-name">
								<a href="../controller/friends-profile.php?friendsname=<?php echo $name['friendsname']; ?>&friendsFirstName=<?php echo $name['firstname']; ?>&friendsLastName=<?php echo $name['lastname']; ?>" class="name"><?php echo $name['friendsname']; ?></a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
			<div class="row justify-content-md-end">
				<div class="col-md-4 column2 user-search">
					<form class="form-group" method="post" action="../controller/user-search.php">
						<input class="form-control form-control-lg" type="text" placeholder="Search for people" name="user-search">
						<input class="btn btn-default my-2 my-sm-2" type="submit" value="Search">
					</form>
				</div>
			</div>
		<?php if (empty($favorite_response)) : ?>
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
					<?php foreach ($favorite_response as $beers => $name) : ?>	
						<a href="../controller/search.php?beer_search=<?php echo $name['beer']; ?>&venue_search=<?php echo $name['beer']; ?>" class="beername"><?php echo $name['beer']; ?></a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
