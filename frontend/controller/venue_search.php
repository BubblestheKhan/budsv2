<?php

session_start();

require_once('../path.inc');
require_once('../get_host_info.inc');
require_once('../rabbitMQLib.inc');

$client = new rabbitMQClient("../testRabbitMQ.ini", "Frontend");

$venue_id = htmlspecialchars($_GET['venue_id']);
$_SESSION['venue_id'] = $venue_id;

$request = array();
$request['type'] = 'venue_search_id';
$request['venue_id'] = urlencode($_SESSION['venue_id']);
$request['message'] = "Searching for the specific brewery";

$response = $client->send_request($request);

require '../view/venue_search.view.php';


?>
