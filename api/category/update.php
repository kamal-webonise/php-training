<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate category object
include_once '../objects/category.php';
 
$database = Database::getInstance();
$db = $database->getConnection();
 
$category = new category($db);

parse_str(file_get_contents("php://input"),$data); 
$category->id = $data['id'];
$category->name = $data['name'];
$category->description = $data['description'];
$category->tax = $data['tax'];
echo $category->id. " ".$category->name. " ".$category->description. " ".$category->tax. " ";

if($category->update()) {
    // set response code - 200 ok
    http_response_code(200);
    echo "category was updated.";
    echo json_encode($category);
}
 
// if unable to update the product, tell the user
else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo "Unable to update category.";
}

?>

<!-- curl -X PUT http://localhost/api/category/update.php -d id=1 -d name="p1" -d description="asdfa" -d tax=2 -->
