<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/category.php';
 
// instantiate database and category object
$database = Database::getInstance();
$db = $database->getConnection();
 
// initialize object
$category = new Category($db);
 
// delete the product
if($category->delete()) {
    // set response code - 200 ok
    http_response_code(200);
    echo "Category was deleted.";
}
 
// if unable to delete the product
else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo "Unable to delete product.";
}
?>

<!-- curl -X DELETE http://localhost/api/category/delete.php -->
