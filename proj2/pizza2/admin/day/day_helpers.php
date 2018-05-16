<?php
// Use $server_orders vs. $undelivered_orders to find newly delivered orders
// Credit their newly delivered orders to inventory and delete such orders from 
// the undelivered_orders table
// $server_orders: array of orders from server
// $undelivered orders: array of orders from undelivered orders table
function record_deliveries($db, $server_orders, $undelivered_orders)
{
    $server_orders = json_decode($server_orders, true);
    $delivered_orders = array();  // build set of delivered orders
    for ($i = 0; $i < count($server_orders); $i++) {
        $orderid = $server_orders[$i]['orderID'];
        $delivered = $server_orders[$i]['delivered'];
        if ($delivered) {
            $delivered_orders[$orderid] = $server_orders[$i];  // remember order by id
        }
    }

    error_log('server orders: ' . print_r($server_orders, true));
    error_log('delivered: ' . print_r($delivered_orders, true));
    // match delivered server order with previously undelivered order
    for ($j = 0; $j < count($undelivered_orders); $j++) {
        $orderID = $undelivered_orders[$j]['orderid'];
        $flour_qty = $undelivered_orders[$j]['flour_qty'];
        $cheese_qty = $undelivered_orders[$j]['cheese_qty'];
        error_log('looking at undel order ' . print_r($undelivered_orders[$j], true));
        if (array_key_exists($orderID, $delivered_orders)) {
            error_log("found newly delivered order $orderID");
            $order = $delivered_orders[$orderID];  // the full order info
            // TODO
            // delete $orderID from undelivered orders table
            // get the quantities of flour and cheese in this order
            // and add them to the inventory table
            mark_delivered($db, $orderID);
            increase_cheese_inventory($db, $cheese_qty);
            increase_flour_inventory($db, $flour_qty);
        }
    }
}

// check inventory and undelivered orders and submit order as needed
function check_inventory($db, $httpClient, $base_url, $admin)
{
    $inventory = get_inventory($db);
    if ($inventory[0]['flour_qty'] == 0 || $inventory[0]['cheese_qty'] == 0) {
        return false;
    }
    $flour_bags_to_order = 0;
    $flour_units_to_order = 0;
    $cheese_units_to_order = 0;
    if ($admin) {
        if ($inventory[0]['flour_qty'] + get_undelivered_flour_units($db) < 150 || $inventory[0]['cheese_qty'] + get_undelivered_cheese_units($db) < 150) {
            $order = ["customerID" => 1];
            $items = array();
            if ($inventory[0]['flour_qty'] + get_undelivered_flour_units($db) < 150) {
                $flour_bags_to_order = flour_bags_needed($inventory[0]['flour_qty'] + get_undelivered_flour_units($db));
                $flour_units_to_order = $flour_bags_to_order * 100;
                $items[] = ["productID" => 11, "quantity" => $flour_bags_to_order];
            }
            if ($inventory[0]['cheese_qty'] + get_undelivered_cheese_units($db) < 150) {
                $cheese_units_to_order = 150 - ($inventory[0]['cheese_qty'] + get_undelivered_cheese_units($db));
                $items[] = ["productID" => 12, "quantity" => $cheese_units_to_order];
            }
            $order['items'] = $items;
            $order_id = post_order($httpClient, $base_url, $order);
            submit_order($db, $order_id, $flour_units_to_order, $cheese_units_to_order);
        }
    }
    return true;
}

// only need 150 max but flour comes in 100-units bag
// so at most need 2 bags
function flour_bags_needed($flour_units)
{
    if ($flour_units >= 50) {
        return 1;
    } else {
        return 2;
    }
}
