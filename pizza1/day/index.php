<?php

require('../model/database.php');
require('../model/initial.php');
require('../model/day_db.php');
require('../model/order_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

$current_day = get_current_day($db)[0]['current_day'];
$todays_orders = get_todays_orders($db, $current_day);

if ($action == 'initial_db') {
    try {
        initial_db($db);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include ('../errors/database_error.php');
        exit();
    }
    header("Location: .");
} else if ($action == 'next_day') {
    try {
        change_current_day($db, $current_day);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();  // needed here to avoid redirection of next line
    }
    // Redirect back to index.php (see pp. 164-165)
    // (don't include index.php inside index.php)
    header("Location: .");
} 
include 'day_list.php';