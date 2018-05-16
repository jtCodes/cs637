<?php
// the try/catch for these actions is in the caller
function add_topping($db, $topping_name)  
{
    $query = 'INSERT INTO menu_toppings (topping) VALUES (:topping_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':topping_name', $topping_name);
    $statement->execute();
    $statement->closeCursor();
}

function get_toppings($db) {
    $query = 'SELECT * FROM menu_toppings';
    $statement = $db->prepare($query);
    $statement->execute();
    $toppings = $statement->fetchAll();
    return $toppings;    
}

function delete_topping($db, $topping_name) {
    $query = "DELETE FROM menu_toppings WHERE topping = '$topping_name'";
    $statement = $db->prepare($query);
    $statement->execute();   
}