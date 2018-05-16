<?php
function get_day() {
    global $db;
    $query = '
        SELECT *
        FROM systemDay';
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result[0]['dayNumber'];
}

function update_day($day)
{
    global $db;
    $query = '
        UPDATE systemDay
        SET dayNumber = :day';
    $statement = $db->prepare($query);
    $statement->bindValue(':day', $day);
    $statement->execute();
    $statement->closeCursor();
}
?>