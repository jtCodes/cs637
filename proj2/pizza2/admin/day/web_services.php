<?php
// Functions to do the base web services needed
// Note that all needed web services are sent from this day directory
// The functions here should throw up to their callers, just like
// the functions in model.
//
// Post day number to server
// Returns if successful, or throws if not
function post_day($httpClient, $base_url, $day) {
    error_log('post_day to server: ' . $day);
    $url = $base_url . '/day/';
    $httpClient->request('POST', $url, ['json' => $day]);
}

// TODO: POST order and get back location (i.e., get new id), get all orders 
// in server and/or get a specific order by orderid

function post_order($httpClient, $base_url, $order) {
    error_log('post_order to server: ' . json_encode($order));
    $url = $base_url . '/orders/';
    $response = $httpClient->request('POST', $url, ['json' => $order]);
    $order_id = $response->getBody();
    return $order_id;
}

function get_orders($httpClient, $base_url) {
    error_log('get_orders to server');
    $url = $base_url . '/orders/';
    $response = $httpClient->get($url);
    return $response->getBody()->getContents();
}

