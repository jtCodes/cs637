<?php
$request_uri = $_SERVER['REQUEST_URI'];
$doc_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
$dirs = explode(DIRECTORY_SEPARATOR, __DIR__);
array_pop($dirs); // remove last element
$project_root = implode('/', $dirs) . '/';
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', '0'); // displayed errors would mess up response
ini_set('log_errors', 1);
// the following file needs to exist, be accessible to apache
// and writable (chmod 777 php-server-errors.log)
ini_set('error_log', $project_root . 'php-server-errors.log');
set_include_path($project_root);
// app_path is the part of $project_root past $doc_root
$app_path = substr($project_root, strlen($doc_root));
// project uri is the part of $request_uri past $app_path, not counting its last /
$project_uri = substr($request_uri, strlen($app_path) - 1);
$parts = explode('/', $project_uri);
// like  /rest/product/1 ;
//     0    1     2    3    

// tell database.php not to send HTML error page
$in_webservice_code = true;
require_once('model/database.php');
require_once('model/product_db.php');
require_once('model/day.php');
require_once('model/order_db.php');
$server = $_SERVER['HTTP_HOST'];
$method = $_SERVER['REQUEST_METHOD'];
$proto = isset($_SERVER['HTTPS']) ? 'https:' : 'http:';
$url = $proto . '//' . $server . $request_uri;
$resource = trim($parts[2]);
$id = $parts[3];
error_log('starting REST server request, method=' . $method . ', uri = ...' . $project_uri);

switch ($resource) {
    // Access the specified product
    case 'products':
        error_log('request at case product');
        switch ($method) {
            case 'GET':
                handle_get_product($id);
                break;
            case 'POST':
                handle_post_product($url);
                break;
            default:
                $error_message = 'bad HTTP method : ' . $method;
                include_once('errors/server_error.php');
                server_error(405, $error_message);
                break;
        }
        break;
    case 'day':
        error_log('request at case day');
        switch ($method) {
            case 'GET':
                $day = get_day();
                handle_get_day($day);
                break;
            case 'POST':
                $day = file_get_contents('php://input');
                $new_day = handle_post_day($day);
                break;
            default:
                $error_message = 'bad HTTP method : ' . $method;
                include_once('errors/server_error.php');
                server_error(405, $error_message);
                break;
        }
        break;
    case 'orders':
        error_log('request at case orders');
        switch ($method) {
            case 'GET':
                if ($id) {
                    handle_get_order_by_id($id);
                } else {
                    handle_get_all_orders();
                }
                break;
            case 'POST':
                handle_post_orders();
                break;
            default:
                $error_message = 'bad HTTP method : ' . $method;
                include_once('errors/server_error.php');
                server_error(405, $error_message);
                break;
        }
        break;
    default:
        $error_message = 'Unknown REST resource: ' . $resource;
        include_once('errors/server_error.php');
        server_error(400, $error_message);  // blame client (but might be server's fault)
        break;
}

function handle_get_product($product_id)
{
    try {
        if (!(is_numeric($product_id) && $product_id > 0)) {
            $error_message = 'Bad product_id in handle_get_product: ' . $product_id;
            include_once('errors/server_error.php');
            server_error(400, $error_message);  // bad client URL
            return;
        }
        $product = get_product($product_id);
        if (empty($product)) {  // no data found
            $error_message = 'failed to find product';
            include_once('errors/server_error.php');
            server_error(404, $error_message);
            return;
        }
        $data = json_encode($product);
        error_log('in handle_get_product, $product = ' . print_r($product, true));
        if ($data === false) {  // failure of json_encode
            $error_message = 'JSON encode error' . json_last_error_msg();
            include_once('errors/server_error.php');
            server_error(500, $error_message);  // server problem
            return;
        }
    } catch (Exception $e) {
        $error_message = 'exception trying to get product' . $e->getMessage();
        include_once('errors/server_error.php');
        server_error(500, $error_message);  // server problem
        return;
    }
    echo $data;
}

function handle_post_product($url)
{
    $bodyJson = file_get_contents('php://input');
    error_log('Server saw post data' . $bodyJson);
    $body = json_decode($bodyJson, true);
    if ($body === null) {  // failure of json_decode 
        $error_message = 'JSON decode error' . json_last_error_msg();
        include_once('errors/server_error.php');
        server_error(400, $error_message);  // client problem: sent bad JSON
        return;
    }
    try {
        $product_id = add_product($body['categoryID'], $body['productCode'], $body['productName'], $body['description'], $body['listPrice'], $body['discountPercent']);
        // return new URI in Location header
        $locHeader = 'Location: ' . $url . $product_id;
        header($locHeader, true, 201);  // needs 3 args to set code 201 (Created)
        error_log('hi from handle_post_product, header = ' . $locHeader);
    } catch (Exception $e) {
        $error_message = 'Insert failed: ' . $e->getMessage();
        include_once('errors/server_error.php');
        server_error(500, $error_message);  // probably server error
    }
}

function handle_get_day($day)
{
    error_log('rest server in handle_get_day, day = ' . $day);
    echo $day;
}

function handle_post_day($day)
{
    error_log('rest server in handle_post_day');
    if (!(is_numeric($day) || $day <= 0)) {
        $error_message = 'Bad day number in handle_post_day: ' . $day;
        include_once('errors/server_error.php');
        server_error(400, $error_message);  // bad client data
        return;
    } else {
        update_day($day);
        if ($day == 0) {
            reset_db();
        }
        error_log('Server saw POSTed day = ' . $day);
        return $day;
    }
}

function handle_get_order_by_id($customer_id)
{
    $order_id = get_orders_by_customer_id($customer_id)[0]['orderID'];
    $items_to_return = handle_get_order_items($order_id);
    if (empty($items_to_return)) {
        header("HTTP/1.1 404 Not Found");
        die();
    } else {
        $order = json_encode(array('customerID' => $customer_id, 'items' => $items_to_return));
        echo $order;
    }
}

function handle_get_all_orders()
{
    $day = get_day();
    $filled_orders = get_filled_orders();
    $unfilled_orders = get_unfilled_orders();
    $all_orders = array();

    foreach ($unfilled_orders as $order) {
        $items_to_return = handle_get_order_items($order['orderID']);
        $delivered = false;
        if ($day >= $order['deliveryDay']) {
            $delivered = true;
        }
        $all_orders[] = array('customerID' => $order['customerID'], 'orderID' => $order['orderID'], 'delivered' => $delivered, 'items' => $items_to_return);
    }
    $all_orders = json_encode($all_orders);
    echo $all_orders;
}

// helper function to handle_get_orders functions
// takes in $order_id as argument and return an items array
function handle_get_order_items($order_id)
{
    $items_from_db = get_order_items($order_id);
    $items_to_return = array();
    foreach ($items_from_db as $item) {
        $items_to_return[] = array('productID' => $item['productID'], 'quantity' => $item['quantity']);
    }
    return $items_to_return;
}

function handle_post_orders()
{   
    // decode json into object
    $post_data = json_decode(file_get_contents('php://input'));

    // add order and get auto-incremented order id from db
    $customerID = $post_data->customerID;
    $order_date = date("Y-m-d");
    $day = get_day();
    $deliveryDay;
    if ($day % 2 == 0) {
        $deliveryDay = $day + 2;
    } else {
        $deliveryDay = $day + 1;
    }
    $order_id = add_order($customerID, $order_date, $deliveryDay);

    // use the returned order id to insert order items to db
    $items = $post_data->items;
    foreach ($items as $item) {
        add_order_item($order_id, $item->productID, 50, 0, $item->quantity);
    }
    echo $order_id;
}
