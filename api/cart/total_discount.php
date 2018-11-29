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
$cart->user_id = $data['user_id'];

$stmt = $cart->discount();
$total_discount = $stmt->fetch(PDO::FETCH_ASSOC);
extract($total_discount);

if($total_discount > 0) {
	echo "Total Discount Amount is ".$total_discount; 
}
else {
	echo "no records found";
}

?>

<!-- curl -X PUT http://localhost/api/cart/total_discount.php -d user_id=2-->
