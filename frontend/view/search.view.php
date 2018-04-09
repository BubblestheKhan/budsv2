<?php 

require('../template/header.html');
require('../template/footer.html'); 

?>

<head>
	<link rel="stylesheet" href="../css/search.css" type="text/css">
</head>

<div class="container main-content">
	<div class="row">
		<div class="col-md-4 beer_brewery_search">
			<form class="form-group" method="POST" action="../controller/search.php">
				<input type="hidden" name="beer_search" value="<?php echo $_SESSION['beer_name']; ?>">
				<button type="submit" class="btn btn-secondary btn-lg btn-block" role="button" value="beer_name">Beer</button>
			</form>
		</div>
		<div class="col-md-4 beer_brewery_search">
			<form class="form-group" method="POST" action="../controller/search.php">
				<input type="hidden" name="venue_search" value="<?php echo $_SESSION['beer_name']; ?>">
				<button type="submit" class="btn btn-secondary btn-lg btn-block" role="button" value="beer_name">Venue</button>
			</form>
		</div>
	</div>
	<?php if (empty($response)) : ?>
		<div class="row">
			<div class="col-md-12 column1">
				<h2 id="errorSearch">Uh Oh... Could not find what you were searching for....</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 column2">
				<h2 class="search_title">Search Again Please?</h2>
				<form class="form-group" method="post" action="../controller/home.php">
					<input class="form-control form-control-lg" type="text" placeholder="What will you be searching for today?" name="search">
				</form>
			</div>
		</div>
	<?php else : ?>
		<?php if ($response['beer_requested'] === True) : ?>
			<?php unset($response['beer_requested']); ?>
			<?php if (empty($response)) : ?>
				<div class="row">
					<div class="col-md-12 column1">
						<h2 id="errorSearch">Uh Oh... Could not find what you were searching for....</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 column2">
						<h2 class="search_title">Search Again Please?</h2>
						<form class="form-group" method="post" action="../controller/home.php">
							<input class="form-control form-control-lg" type="text" placeholder="What will you be searching for today?" name="search">
						</form>
					</div>
				</div>
			<?php else : ?>
				<?php foreach ($response as $information) : ?>
					<div class="row">
						<div class="col-md-6 column1">
							<h2 id="title"><a href="beer_search.php?beer_name=<?php echo $information['name']; ?>"><?php echo $information['name']; ?></a></h2>
							<p class="information"><?php echo $information['category']; ?></p>
						</div>
						<div class="col-md-3 column2">
							<p class="information"><span class="subtitle">ABV: </span><?php echo $information['abv']; ?></p>
							<p class="information"><span class="subtitle">Available: </span><?php echo $information['available']; ?></p>
						</div>

					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php elseif ($response['venue_requested'] === True) : ?>
			<?php unset($response['venue_requested']); ?>
			<?php if (empty($response)) : ?>
				<div class="row">
					<div class="col-md-12 column1">
						<h2 id="errorSearch">Uh Oh... Could not find what you were searching for....</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 column2">
						<h2 class="search_title">Search Again Please?</h2>
						<form class="form-group" method="post" action="../controller/home.php">
							<input class="form-control form-control-lg" type="text" placeholder="What will you be searching for today?" name="search">
						</form>
					</div>
				</div>
			<?php else : ?>
				<?php foreach ($response as $information) : ?>
					<div class="row">
						<div class="col-md-8 column1">
							<h2 id="title"><a href="venue_search.php?venue_id=<?php echo $information['id']; ?>"><?php echo $information['name']; ?></a></h2>
							<p class="venue_information"><?php echo $information['nickname']; ?></p>
							<p class="venue_information"><?php echo $information['type']; ?></p>
							<p class="venue_information"><?php echo $information['brand']; ?></p>
							<p class="venue_information">
								<?php echo $location['state']; ?>
							</p>
							<p class="venue_information"><?php echo $information['town']; ?>
							<p class="venue_information"><?php echo $information['address']; ?>
							</p>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
</div>


