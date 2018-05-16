<?php
require('../../util/main.php');
require('../../model/database.php');
require('../../model/day_db.php');
require('../day/web_services.php');
require('../../model/initial.php');
require_once('../../util/main.php');
require '../../vendor/autoload.php';
require('../../model/inventory_db.php');
require('../day/day_helpers.php');

$spot = strpos($app_path, 'pizza2');
$part = substr($app_path, 0, $spot);
$base_url = $_SERVER['SERVER_NAME'] . $part . 'proj2_server/rest';
$httpClient = new \GuzzleHttp\Client();
$url = 'http://' . $base_url . '/day/';

$action = filter_input(INPUT_POST, 'action');
if ($action == null) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == null) {
        $action = 'list';
    }
}

$current_day = get_current_day($db);
if ($action == 'list') {
    try {
        // TODO:
        // Load variables for displayed info on supplies on order and inventory
        $todays_orders = get_orders_for_day($db, $current_day);
        $inventory = get_inventory($db);
        $undelivered_orders = get_undelivered_orders($db);
    } catch (Exception $e) {
        include('../../errors/error.php');
        exit();
    }
    include('day_list.php');
} else if ($action == 'next_day') {
    try {
        finish_orders_for_day($db, $current_day);
        increment_day($db);
        $current_day++;
        post_day($httpClient, $base_url, $current_day);
        record_deliveries($db, get_orders($httpClient, $base_url), get_undelivered_orders($db));
        check_inventory($db, $httpClient, $base_url, true);
        $inventory = get_inventory($db);
        $undelivered_orders = get_undelivered_orders($db);
    } catch (Exception $e) {
        include('../../errors/error.php');
        exit();
    }
    // TODO: without putting a huge amount of code here: 
    //   see day_helpers.php for some starter code, add other functions there
    // POST the new day number to the server by calling post_day in web_services.php
    // Get the undelivered orders from pizza2's database
    // Get the supply order status from the server by calling into web_services.php
    // Determine new deliveries by analyzing undelivered orders and server status info.
    // Add any newly delivered order amounts to inventory
    // Remove processed orders from undelivered orders table
    // Place a new supply order if necessary, via web_services.php
    // Add any new supply order to undelivered orders table
    // Load variables for displayed info on supplies on order and inventory
   
    // Avoiding redirect here for easier debugging: set up needed variables for day_list
    $todays_orders = array(); // new day: no customer orders yet
    include('day_list.php');
} else if ($action == 'initial_db') {
    try {
        initial_db($db);
        // TODO: 
        // POST day 0 to the server. 
        // Get the current inventory info
        // Place new supply order as required by same algorithm as above
        // add order to undelivered orders table

        post_day($httpClient, $base_url, 0);
        check_inventory($db, $httpClient, $base_url, true);
        header("Location: .");
    } catch (Exception $e) {
        include('../../errors/error.php');
        exit();
    }
}
?>