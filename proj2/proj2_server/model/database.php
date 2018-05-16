<?php
// Set up the database connection
if (gethostname() === 'topcat') {
    $username = 'jiaant';  // mysql username on topcat is UNIX username
    $password = $username;
    $location = '/cs637/' . $username;  // where on server: student dir

    $dsn = 'mysql:host=localhost;dbname=' . $username . 'db';
} else {  // dev machine,
    $dsn = 'mysql:host=localhost;dbname=proj2_server';
    $username = 'svr_user';
    $password = 'pa55word';
}
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    error_log("Failed to get DB connection, error = $error_message");
    if ($in_webservice_code) {  // no user, send back HTTP code
        include('errors/server_error.php');
        $code = 500;  // we can't serve anything meaningful, so send worst news
        server_error($code, $error_message);
    } else {
        include('errors/db_error_connect.php');
    }
    exit();
}

// Clean out orders and arrange for first orderID to be 1
function reset_db()
{
    global $db;
    $query = '
    delete from orderItems;
    delete from orders;
    ALTER TABLE orders AUTO_INCREMENT = 0;
    UPDATE systemDay SET dayNumber = 1';
    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
}
?>