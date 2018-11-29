<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

 
// include database and object file
include_once '../config/database.php';
include_once '../objects/cart.php';
 
// get database connection
$database = Database::getInstance();
$db = $database->getConnection();

$cart = new Cart($db);

$stmt = $cart->read();
$num = $stmt->rowCount();
echo $num; 
// check if more than 0 record found
if($num>0){
 
    // cart array
    $cart_arr=array();
    $cart_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $product_item=array(
            "id" => $id,
            "product_id" => $product_id,
            "category_id" => $category_id,
            "total" => $total,
            "total_discount" => $total_discount,
            "total_after_discount" => $total_after_discount,
            "total_tax" => $total_tax,
            "grand_total" => $grand_total,
        );
 
        array_push($cart_arr["records"], $product_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show cart data in json format
    echo json_encode($cart_arr,JSON_PRETTY_PRINT);
}
else {
 
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(
        array("message" => "No cart found.")
    );
}

?>

<!-- curl -X GET http://localhost/api/cart/read.php-->
