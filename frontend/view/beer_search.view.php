<?php 

require('../template/header.html');
require('../template/footer.html'); 

?>

	<div class="container main-content">
		<div class="row">
			<div class="col-md-8 column1">
				<h2 id="title"><?php echo $response['name']; ?></h2>
				<p class="information"><?php echo $response['category']; ?></p>
			
			<!--<button type="button">Favorite <a onclick="favBeer('.$itemId.')" > </a></button> -->
				<form method="POST" action="../controller/beer_add.php">
					<input type="hidden" name="beer_name" value="<?php echo $_SESSION['beer']; ?>">
					<button type="submit" class="btn btn-outline-success" role="button">Add</button>
				</form>

			</div>

			<div class="col-md-4 column2">
				<p class="information"><span class="subtitle">ABV: </span><?php echo $response['abv']; ?></p>
				<p class="information"><span class="subtitle">Available: </span><?php echo $response['available']; ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 column1">
				<p><?php echo $response['description']; ?></p>
			</div>
		</div>
	</div>
	
	<script language="javascript" src="rating.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>
</html>
