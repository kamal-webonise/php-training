<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
 
// get database connection
$database = Database::getInstance();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);
 
parse_str(file_get_contents("php://input"),$data); 
$product->id = $data['id'];
$product->name = $data['name'];
$product->price = $data['price'];
$product->description = $data['description'];
$product->category_id = $data['category_id'];
 
// update the product
if($product->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo "Product was updated.";
    echo json_encode($product);
}
 
// if unable to update the product
else{
    // set response code - 503 service unavailable
    http_response_code(503);
    echo "Unable to update product.";
}
?>

<!-- curl -X PUT http://localhost/api/product/update.php -d id=1 -d name="p1" -d price= 10 -d description="asdfa" -d category_id=2 -->
