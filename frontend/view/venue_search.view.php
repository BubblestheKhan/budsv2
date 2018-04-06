<?php 

require('../template/header.html');
require('../template/footer.html'); 

?>

<div class="container">
	<div class="row">
		<div class="col-md-8 column1">
			<h2 id="title"><?php echo $response['name']; ?></h2>
			<p class="venue_information"><?php echo $response['nickname']; ?></p>
			<p class="venue_information"><?php echo $response['type']; ?></p>
			<p class="venue_information"><?php echo $response['brand']; ?></p>
			<p class="venue_information"><?php echo $response['description']; ?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 column1">
			<iframe width="100%" height="700" frameborder="0" style="border: 0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAXKH9juVz8VFlkiS0aRFyhXT8IhJii_Yk&q=<?php echo $location['address'], $location['town'], $location['state']; ?>
			" allowfullscreen>
			</iframe>
		</div>
	</div>
</div>
