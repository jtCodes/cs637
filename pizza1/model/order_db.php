<?php

function add_order_topping($db, $topping, $order_id)  
{
    $query = 'INSERT INTO order_topping (order_id, topping) VALUES (:order_id, :topping)';
    $statement = $db->prepare($query);
    $statement->execute(array(':order_id' => $order_id, ':topping' => $topping));
    $statement->closeCursor();
}

function get_order_toppings($db, $order_id) {
    $query = "SELECT * FROM order_topping  WHERE order_id = $order_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $toppings = $statement->fetchAll();
    return $toppings; 
}

function add_pizza_order($db, $room, $size, $day, $status)  
{
    $query = 'INSERT INTO pizza_orders (room_number, size, day, status) VALUES (:room_number, :size, :day, :status)';
    $statement = $db->prepare($query);
    $statement->execute(array(':room_number' => $room, ':size' => $size, ':day' => $day, ':status'=> $status));
    $statement->closeCursor();
    $id = $db->lastInsertId();
    return $id;
}

function get_orders($db, $room) {
    $query = "SELECT * FROM pizza_orders, order_topping WHERE room_number = $room AND NOT status = 'Finished' AND pizza_orders.id = order_topping.order_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $orders = $statement->fetchAll();
    return $orders; 
}

function get_todays_orders($db, $day) {
    $query = "SELECT * FROM pizza_orders WHERE day = $day";
    $statement = $db->prepare($query);
    $statement->execute();
    $orders = $statement->fetchAll();
    return $orders; 
}

function get_baked($db, $day) {
    $query = "SELECT * FROM pizza_orders WHERE day = '$day' AND status = 'Baked'";
    $statement = $db->prepare($query);
    $statement->execute();
    $baked = $statement->fetchAll();
    return $baked; 
}

function get_preparing($db, $day) {
    $query = "SELECT * FROM pizza_orders WHERE day = '$day' AND status = 'Preparing' ORDER BY id ASC";
    $statement = $db->prepare($query);
    $statement->execute();
    $preparing = $statement->fetchAll();
    return $preparing; 
}

function mark_oldest_baked($db, $id) {
    $query = "UPDATE pizza_orders SET status = 'Baked' WHERE id = $id";
    $statement = $db->prepare($query);
    $statement->execute();
}

function mark_baked_delivered($db, $room) {
    $query = "UPDATE pizza_orders SET status = 'Finished' WHERE room_number = $room AND status = 'Baked'";
    $statement = $db->prepare($query);
    $statement->execute();
}