<?php

function add_size($db, $size_name)  
{
    $query = 'INSERT INTO menu_sizes (size) VALUES (:size_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':size_name', $size_name);
    $statement->execute();
    $statement->closeCursor();
}

function get_sizes($db) {
    $query = 'SELECT * FROM menu_sizes';
    $statement = $db->prepare($query);
    $statement->execute();
    $toppings = $statement->fetchAll();
    return $toppings;    
}

function delete_size($db, $size_name) {
    $query = "DELETE FROM menu_sizes WHERE size = '$size_name'";
    $statement = $db->prepare($query);
    $statement->execute();   
}