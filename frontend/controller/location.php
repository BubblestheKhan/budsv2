<?php

session_start();

require_once('../path.inc');
require_once('../get_host_info.inc');
require_once('../rabbitMQLib.inc');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$request = array();
$request['type'] = 'location_search';
$request['location_search'] = urlencode($_SESSION['venue_id']);
$request['message'] = "Searching for the address of the venue";

$location = $client->send_request($request);

?>

