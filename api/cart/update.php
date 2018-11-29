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

parse_str(file_get_contents("php://input"),$data); 
$cart->id = $data['id'];
$cart->product_id = $data['product_id'];
$cart->category_id = $data['category_id'];
$cart->quantity = $data['quantity'];
 
// update the cart
if($cart->update()) {
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo "cart was updated.";
    echo json_encode($cart);
}
 
// if unable to update the cart
else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo "Unable to update cart.";
}

?>

<!-- curl -X PUT http://localhost/api/cart/update.php -d id=70 -d product_id=1 -d  category_id=3 -d quantity= 3-->
