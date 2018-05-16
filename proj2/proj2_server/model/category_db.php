<?php

function get_categories()
{
    global $db;
    $query = 'SELECT *,
                (SELECT COUNT(*)
                 FROM products
                 WHERE products.categoryID = categories.categoryID)
                 AS productCount
              FROM categories
              ORDER BY categoryID';
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function get_category($category_id)
{
    global $db;
    $query = '
        SELECT *
        FROM categories
        WHERE categoryID = :category_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function add_category($name)
{
    global $db;
    $query = 'INSERT INTO categories
                 (categoryName)
              VALUES
                 (:name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $statement->closeCursor();

    // Get the last product ID that was automatically generated
    $category_id = $db->lastInsertId();
    return $category_id;
}

function update_category($category_id, $name)
{
    global $db;
    $query = '
        UPDATE categories
        SET categoryName = :name
        WHERE categoryID = :category_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $statement->closeCursor();
}

function delete_category($category_id)
{
    global $db;
    $query = 'DELETE FROM categories WHERE categoryID = :category_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $statement->closeCursor();
}

?>