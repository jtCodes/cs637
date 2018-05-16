<?php

require('../model/database.php');
require('../model/order_db.php');
require('../model/initial.php');
require('../model/day_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_orders';
    }
}

$day = get_current_day($db)[0]['current_day'];
$preparing_pizzas = get_preparing($db, $day);

if ($action == 'list_orders') {
    $baked_pizzas = get_baked($db, $day);
    include('order_list.php');
} else if ($action == 'mark_baked') {
    try {
        if (!empty($preparing_pizzas)){
            (int)$oldest_preparing = $preparing_pizzas[0]['id'];
            mark_oldest_baked($db, $oldest_preparing);
        }
        header("Location: .");
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include ('../errors/database_error.php');
    }
}
