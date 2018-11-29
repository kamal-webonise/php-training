<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/cart.php';

$database = Database::getInstance();
$db = $database->getConnection();

$cart = new Cart($db);

$cart->product_id = 70;
$cart->quantity = 2;

// create the cart
if($cart->create()) {

    http_response_code(201);
    echo "cart was created.";
    echo json_encode($cart,JSON_PRETTY_PRINT);
}

// if unable to create the cart
else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo "Unable to create cart.";
}
?>

<!-- curl -X POST http://localhost/api/cart/create.php -->
