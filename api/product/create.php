<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/product.php';
 
$database = Database::getInstance();
$db = $database->getConnection();
 
$product = new Product($db);

$product->name = "pesdfsi-shoe";
$product->description = "shoe";
$product->price = 3000;
$product->discount = 50;
$product->category_id = 7;
$product->created = date('Y-m-d H:i:s');

// create the product
if($product->create()) {

    http_response_code(201);
    echo "Product was created.";
    echo json_encode($product,JSON_PRETTY_PRINT);
}

// if unable to create the product
else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo "Unable to create product.";
}

?>

<!-- curl -X POST http://localhost/api/product/create.php -->
