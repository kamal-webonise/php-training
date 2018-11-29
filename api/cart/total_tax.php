<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/cart.php';

// $database = new Database();
$database = Database::getInstance();
$db = $database->getConnection();
$cart = new Cart($db);

parse_str(file_get_contents("php://input"),$data); 
$cart->user_id = $data['user_id'];

$stmt = $cart->total_tax();
$total_cost = $stmt->fetch(PDO::FETCH_ASSOC);
extract($total_cost);

if($total_tax > 0) {
	echo "Total Tax Amount is ".$total_tax; 
}
else {
	echo "no records found";
}

?>

<!-- curl -X PUT http://localhost/api/cart/total_tax.php -d user_id=2-->
