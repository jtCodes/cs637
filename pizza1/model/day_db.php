<?php

function get_current_day($db) {
    $query = 'SELECT * FROM pizza_sys_tab';
    $statement = $db->prepare($query);
    $statement->execute();
    $current_day = $statement->fetchAll();
    return $current_day;    
}

function change_current_day($db, $previous_day) {
    $current_day = $previous_day + 1; 
    $query = "UPDATE pizza_sys_tab SET current_day = $current_day";
    $statement = $db->prepare($query);
    $statement->execute();
}
