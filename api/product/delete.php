<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/product.php';
 
// get database connection
$database = Database::getInstance();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);
 
// get product id
parse_str(file_get_contents("php://input"),$data);
 
// set product id to be deleted
$product->id = $data['id'];
 
// delete the product
if($product->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
    echo "Product was deleted.";
    echo json_encode($product,JSON_PRETTY_PRINT);
}
 
// if unable to delete the product
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
    echo "Unable to delete product.";
}
?>

<!-- curl -X DELETE http://localhost/api/product/delete.php -d id=2 -->
