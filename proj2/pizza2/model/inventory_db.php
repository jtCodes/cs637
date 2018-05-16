<?php

function submit_order($db, $order_id, $flour_qty, $cheese_qty)
{
    $query = 'INSERT INTO undelivered_orders
                 (orderid, flour_qty, cheese_qty)
              VALUES
                 (:orderid, :flour_qty, :cheese_qty)';
    $statement = $db->prepare($query);
    $statement->bindValue(':orderid', $order_id);
    $statement->bindValue(':flour_qty', $flour_qty);
    $statement->bindValue(':cheese_qty', $cheese_qty);
    $statement->execute();
    $statement->closeCursor();
}

function mark_delivered($db, $order_id)
{
    $query = 'DELETE FROM undelivered_orders
                 WHERE orderid = :order_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':order_id', $order_id);
    $statement->execute();
    $statement->closeCursor();
}

function decrease_flour_inventory_by_one($db)
{
    $query = '
    UPDATE inventory
    SET flour_qty = flour_qty - 1';
    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
}

function decrease_cheese_inventory_by_one($db)
{
    $query = '
    UPDATE inventory
    SET cheese_qty = cheese_qty - 1';
    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
}

function increase_flour_inventory($db, $qty)
{
    $query = '
        UPDATE inventory
        SET flour_qty = flour_qty + :qty';
    $statement = $db->prepare($query);
    $statement->bindValue(':qty', $qty);
    $statement->execute();
    $statement->closeCursor();
}

function increase_cheese_inventory($db, $qty)
{
    $query = '
        UPDATE inventory
        SET cheese_qty = cheese_qty + :qty';
    $statement = $db->prepare($query);
    $statement->bindValue(':qty', $qty);
    $statement->execute();
    $statement->closeCursor();
}

function get_inventory($db)
{
    $query = 'SELECT * FROM inventory';
    $statement = $db->prepare($query);
    $statement->execute();
    $inventory = $statement->fetchAll();
    return $inventory;
}

function get_undelivered_flour_units($db)
{
    $query = 'SELECT SUM(flour_qty) AS undelivered_flour_units FROM undelivered_orders';
    $statement = $db->prepare($query);
    $statement->execute();
    $undelivered_flour_units = $statement->fetchAll();
    return $undelivered_flour_units[0]['undelivered_flour_units'];
}

function get_undelivered_cheese_units($db)
{
    $query = 'SELECT SUM(cheese_qty) AS undelivered_cheese_units FROM undelivered_orders';
    $statement = $db->prepare($query);
    $statement->execute();
    $undelivered_cheese_units = $statement->fetchAll();
    return $undelivered_cheese_units[0]['undelivered_cheese_units'];
}

function get_undelivered_orders($db)
{
    $query = 'SELECT * FROM undelivered_orders';
    $statement = $db->prepare($query);
    $statement->execute();
    $undelivered_orders = $statement->fetchAll();
    return $undelivered_orders;
}
?>