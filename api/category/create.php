<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/category.php';
 
$database = Database::getInstance();
$db = $database->getConnection();
 
$category = new category($db);

$category->name = "pesdfsi-shoe";
$category->description = "shoe";
$category->tax = 3000;
$category->created = date('Y-m-d H:i:s');

// create the product
if($category->create()){
    http_response_code(201);
    echo "Product was created.";
    echo json_encode($category,JSON_PRETTY_PRINT);
}

// if unable to create the product
else{
    // set response code - 503 service unavailable
    http_response_code(503);
    echo "Unable to create product.";
}

?>

<!-- curl -X POST http://localhost/api/category/create.php -->
