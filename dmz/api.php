<?php

require_once("rabbitmq_required.php");

function requestProcessor($request) {
	echo "Request received".PHP_EOL;

	if(!isset($request['type'])) {
		return "Error: unsupported message type";
	}

	switch ($request['type']) {

		case "beer_search_name":
			return beer_search_name($request['beer_name']);

		case "beer_search_all":
			return beer_search_all($request['beer_all']);

		case "location_search":
			return location_search($request['location_search']);

		case "venue_search_id":
			return venue_search_name($request['venue_id']);

		case "venue_search_all":
			return venue_search_all($request['venue_all']);

	}

	return array("returnCode" => '0', 'message' => "Server received request and processed");
}

function location_search($apiLocationSearch) {

	$location_info = $apiLocationSearch;
	$curl = curl_init();
	$apikey = '35ac36973944221658d74aee2f32bb0c';
	$BASE_URL = "http://api.brewerydb.com/v2/";
	curl_setopt_array($curl, array(
		CURLOPT_URL => "$BASE_URL/brewery/$location_info/locations/?key=$apikey",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);

	curl_close($curl);

	$response_format = json_decode($response, true);
	$location_array = array();

	foreach ($response_format as $data => $value) {
		if ($data === 'data') {
			foreach ($value as $label => $info) {
				foreach ($info as $names => $location) {
					var_dump($location);
					if ($names === 'region') {
						$location_array['state'] = htmlspecialchars($location);
					}

					if ($names === 'postalCode') {
						$location_array['zipcode'] = $location;
					}

					if ($names === 'latitude') {
						$location_array['latitude'] = $location;
					}

					if ($names === 'longitude') {
						$location_array['longitude'] = $location;
					}

					if ($names === 'locality') {
						$location_array['town'] = htmlspecialchars($location);
					}

					if ($names === 'streetAddress') {
						$location_array['address'] = htmlspecialchars($location);
					}
				}
			}
		}
	}

	var_dump($location_array);
	return $location_array;
}

function beer_search_name($apiBeerSearch) {

	$beer_info = $apiBeerSearch;
	$curl = curl_init();
	$apikey = '35ac36973944221658d74aee2f32bb0c';
	$BASE_URL = "http://api.brewerydb.com/v2/";

	curl_setopt_array($curl, array(
		CURLOPT_URL => "$BASE_URL/beers/?name=$beer_info&key=$apikey",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);

	curl_close($curl);

	$response_format = json_decode($response, true);
	$result_array = array();
	

	var_dump($response_format);
	foreach ($response_format as $key => $value) {
		if ($key === 'data') {
			for ($i = 0; $i < count($value); $i++) {
				foreach ($value[$i] as $data => $information) {
					if ($data === 'name') {
						$result_array['name'] = $information;
						

					}
					if ($data === 'description') {
						$result_array['description'] = $information;
						
					}
					if ($data === 'available') {
						foreach ($information as $availData => $availInformation) {
							if ($availData === 'name') {
								$result_array['available'] = $availInformation;
								
							}
						}
					}

					if ($data === 'style') {
						foreach ($information as $styleType => $styleInformation) {
							if ($styleType === 'name') {
								$result_array['type'] = $styleInformation;
								
							}
							if ($styleType === 'category') {
								foreach ($styleInformation as $category_type => $category_name) {
									if ($category_type === 'name') {
										$result_array['category'] = $category_name;
									
									}
								}
							}
						}
					}

					if ($data === 'abv') {
						$result_array['abv'] = $information;
					}
				}
			} 
		}
	}
	print_r($result_array);
	return $result_array;
}

function beer_search_all($apiSearch) {

	$beer_info = $apiSearch;

	$curl = curl_init();
	$apikey = '35ac36973944221658d74aee2f32bb0c';
	$BASE_URL = "http://api.brewerydb.com/v2/";

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "$BASE_URL/search?key=$apikey&q=$beer_info&type=beer",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "Cache-Control: no-cache",
	    "Postman-Token: 422ba6f5-6dcd-7c46-5837-690d8831e089"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	$api_data = json_decode($response);
	
	var_dump($api_data);

	$api_array = array();
	$api_test = array();
	//['data'] = count(50) => 0 = index => ['name']

	        //array   key     value
	foreach ($api_data as $data => $category) {
	  if ($data === 'data') {
	    foreach ($category as $key => $value) {
	      foreach ($value as $labels => $names) {
	        if ($labels === 'name') {
	          $api_array['name'] = $names;
	        }

	        if ($labels === 'abv') {
	          $api_array['abv'] = $names;
	        }

	        if ($labels === 'available') {
	          foreach ($names as $available => $availDescription) {
	            if ($available === 'name') {
	              $api_array['available'] = $availDescription;
	            }
	          }
	        }

	        if($labels === 'style') {
	          foreach ($names as $category => $categoryDescription) {
	            if ($category === 'name') {
	              $api_array['category'] = $categoryDescription;
	            }
	            if ($category === 'description') {
	            	$api_array['description'] = $categoryDescription;
	            }
	          }
	        }
	      }
	      if (count($api_array) >= 5) {
	      	array_push($api_test, $api_array);
	    	$api_array = array();
	      }
	    }
	  }
	}
	$api_test['beer_requested'] = True;
	print_r($api_test);
	return $api_test;
}

function venue_search_name($apiSearch) {

	$venue_info = $apiSearch;

	$curl = curl_init();
	$apikey = '35ac36973944221658d74aee2f32bb0c';
	$BASE_URL = "http://api.brewerydb.com/v2/";

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "$BASE_URL/brewery/$venue_info/?key=$apikey",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "Cache-Control: no-cache",
	    "Postman-Token: 422ba6f5-6dcd-7c46-5837-690d8831e089"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	$api_data = json_decode($response);
	
	$api_array = array();
	//['data'] = count(50) => 0 = index => ['name']

	        //array   key     value
	foreach ($api_data as $data => $category) {
	  if ($data === 'data') {
	    foreach ($category as $key => $value) {
	        if ($key === 'name') {
	          $api_array['name'] = $value;
	        }

	        if ($key === 'nameShortDisplay') {
	        	$api_array['nickname'] = $value;
	        }

	        if ($key === 'description') {
	          $api_array['description'] = $value;
	        }

	        if ($key === 'website') {
	          $api_array['website'] = $value;
	        }

	        if ($key === 'type') {
	        	$api_array['type'] = $value;
	        }

	        if($key === 'brandClassification') {
	          	$api_array['brand'] = $value;
	   
	        }
	      }
	    }
	}

	var_dump($api_array);
	return $api_array;
}

function venue_search_all($apiSearch) {

	$venue_info = $apiSearch;

	$curl = curl_init();
	$apikey = '35ac36973944221658d74aee2f32bb0c';
	$BASE_URL = "http://api.brewerydb.com/v2/";

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "$BASE_URL/search?key=$apikey&q=$venue_info&type=brewery&withBreweries=Y",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "Cache-Control: no-cache",
	    "Postman-Token: 422ba6f5-6dcd-7c46-5837-690d8831e089"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	$api_data = json_decode($response);
	

	$api_array = array();
	$api_test = array();
	//['data'] = count(50) => 0 = index => ['name']

	        //array   key     value
	var_dump($api_data);
	foreach ($api_data as $data => $category) {
	 	if ($data === 'data') {
		    foreach ($category as $key => $value) {
		    	foreach ($value as $labels => $names) {
		    		if ($labels === 'id') {
		    			$api_array['id'] = $names;
		    		}

			        if ($labels === 'name') {
			          $api_array['name'] = $names;
			        }

			        if ($labels === 'nameShortDisplay') {
			        	$api_array['nickname'] = $names;
			        }

			        if ($labels === 'description') {
			          $api_array['description'] = $names;
			        }

			        if ($labels === 'website') {
			          $api_array['website'] = $names;
			        }

			        if ($labels === 'type') {
			        	$api_array['type'] = $names;
			        }

			        if($labels === 'brandClassification') {
			          	$api_array['brand'] = $names;
			   
			    	}
		    	}
		     	array_push($api_test, $api_array);
		    	$api_array = array();

	    	}
	  	}
	}
	$api_test['venue_requested'] = True;
	var_dump($api_test);
	return $api_test;
}


$server = new rabbitMQServer("testRabbitMQ.ini", "Backend");
$server->process_requests('requestProcessor');

exit();

?>
