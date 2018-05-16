<?php

require('../model/database.php');
require('../model/order_db.php');
require('../model/size_db.php');
require('../model/topping_db.php');
require('../model/day_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'welcome';
    }
}

if ($action == 'welcome') {
    try {
        $room = 1;
        $toppings = get_toppings($db);
        $sizes = get_sizes($db);
        $orders = get_orders($db, $room);
        include('student_welcome.php');
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
    }
} else if ($action == 'select_room') {
    $room = $room = (int)$_POST['room'];
    $toppings = get_toppings($db);
    $sizes = get_sizes($db);
    $orders = get_orders($db, $room);
    include('student_welcome.php');
} else if ($action == 'show_order_form') {
    $room = $_GET['room'];
    $toppings = get_toppings($db);
    $sizes = get_sizes($db);
    include('order_pizza.php');
} else if ($action == 'order_pizza') {
    try {
         $room = (int)$_POST['room'];
         $size = $_POST['size'];
         $day = (int)get_current_day($db)[0]['current_day'];
         $order_id = add_pizza_order($db, $room, $size, $day, "Preparing");
         $topping = implode(' ',$_POST['topping']);
         add_order_topping($db, $topping, $order_id);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();  // needed here to avoid redirection of next line
    }
    header("Location: .");
} else if ($action == 'pizza_delivered') {
    try {
        $room = (int)$_POST['room'];
        mark_baked_delivered($db, $room);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();  // needed here to avoid redirection of next line
    }
    header("Location: .");
}