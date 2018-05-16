<?php
// Client-side REST requests: example code for pizza2 project
require_once('../util/main.php');
// use Composer autoloader, so we don't have to require Guzzle PHP files
require '../vendor/autoload.php';

// Now have $app_path, path from doc root to parent directory
// $app_path is of form /cs637/user/proj2/pizza2
// We want URL say http://localhost/cs637/user/proj2/proj2_server/rest for REST service
// So drop "pizza2" from $app_path, add /proj2_server/rest
echo 'app_path: ' . $app_path . '<br>';
$spot = strpos($app_path, 'pizza2');
$part = substr($app_path, 0, $spot);
$base_url = $_SERVER['SERVER_NAME'] . $part . 'proj2_server/rest';
echo 'base_url: ' . $base_url . '<br>';

// Instantiate Guzzle HTTP client
$httpClient = new \GuzzleHttp\Client();
$url = 'http://' . $base_url . '/day/';
echo 'POST day = 3 to ' . $url . '<br>';
$fp = fopen('php://temp', 'r+');   // for more debug info if desired
error_log('...... restclient: POST day = 3 to ' . $url);
try {
    $response = $httpClient->request('POST', $url, ['json' => 3, 'debug'=> $fp]);
    $status = $response->getStatusCode();
   // fseek($fp, 0);
   // var_dump(stream_get_contents($fp));  // uncomment for additional debug output

} catch (GuzzleHttp\Exception $e) {
    $status = 'POST failed, error = ' . $e;
    error_log($status);
    include '../errors/error.php';  // Note new error.php code that handles Exceptions
}
echo 'Post of day result: ' .  $status;
echo '<br>GET of day to ' . $url;
error_log('...... restclient: GET day');
try {
    $response2 = $httpClient->get($url,['debug' => $fp]);
    echo '<br>Back from GET: day = ' . $response2->getBody() . ' (wrong until server coded right)';
} catch (Exception $e) {
    include '../errors/error.php'; 
}
//fseek($fp, 0);  
//var_dump(stream_get_contents($fp)); // uncomment for additional debug output

$product_id = 1;
$url = 'http://' . $base_url . '/products/' . $product_id;
echo '<br>GET of product 1 to ' . $url;
error_log('...... restclient: GET product');
try {
    $response3 = $httpClient->get($url);
    $prodJson = $response3->getBody()->getContents();  // as StreamInterface, then string
    echo '<br> Returned result of GET of product 1: <br>';
    print_r($prodJson);
    echo '<br> After json_decode:<br>';
    $product = json_decode($prodJson, true);
    print_r($product);
} catch (Exception $e) {
    include '../errors/error.php'; 
}
echo  '<br>Now POST it back, but on second run, expect to see an error unless you change productCode in index.php';

$url = 'http://' . $base_url . '/products/';
$product['productCode'] = 'strat04';  // works only once per each value

error_log('...... restclient: POST product');
try {
    // Guzzle does the json_encode for us--
    $response4 = $httpClient->request('POST', $url, ['json' => $product]);
    $location4 = $response4->getHeader('Location');
    $status4 = $response4->getStatusCode();
} catch (Exception $e) {
  include '../errors/error.php'; 
}

if (isset($status2)) {
    echo "POST of product result: status = $status4 <br>";
    echo "Location = ";
    echo var_dump($location2) . '<br>';
}

echo '<br> If error is 500 Internal Server Error, it is probably because of constraint violation'; 
echo '<br> on the unique column productCode preventing insert on the server side';
echo '<br> If so, you can fix it by changing productCode to a new value in restclient/index.php';
