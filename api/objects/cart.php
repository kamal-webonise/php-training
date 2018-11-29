<?php
class Cart {
 
    private $conn;
    private $table_name = "cart";
 
    public $id;
    public $product_id;
    public $category_id;
    public $total;
    public $total_discount;
    public $total_after_discount;
    public $total_tax;
    public $grand_total;
    public $created;
 
    function __construct($db){
        $this->conn = $db;
    }

    function create() {
        // get values from Products and Categories Table
        $query = "select c.tax, p.price, p.discount, p.category_id
                FROM products p LEFT JOIN categories c ON p.category_id = c.id and p.id = ".$this->product_id;
        $stmt = $this->conn->prepare($query);

        if(!$stmt->execute()) {
            return false;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $this->total = $price * $this->quantity;
        $this->category_id = $category_id;
        $this->total_discount = ($discount/100) * $price;
        $this->total_after_discount = $this->total - $this->total_discount;
        $this->total_tax = ($tax/100) * $this->total_after_discount;
        $this->grand_total = $this->total_after_discount + $this->total_tax;

        // insert into cart table
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    total= :total, total_discount= :total_discount, total_after_discount= :total_after_discount, category_id= :category_id,product_id= :product_id, total_tax= :total_tax, grand_total= :grand_total, quantity= :quantity";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->bindParam(":total", $this->total);
        $stmt->bindParam(":total_discount", $this->total_discount);
        $stmt->bindParam(":total_after_discount", $this->total_after_discount);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":total_tax", $this->total_tax);
        $stmt->bindParam(":grand_total", $this->grand_total);
        $stmt->bindParam(":quantity", $this->quantity);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function delete() {
        
        $query = "DELETE FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function update() {
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    product_id = :product_id,
                    category_id = :category_id,
                    quantity = :quantity,
                WHERE
                    id = :id";
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function read() {

        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
     
        // execute query
        if($stmt->execute()){
            return $stmt;
        }
     
        return false;
    }

    function get_total() {
        $query = "Select SUM(grand_total) as grand_total from " . $this->table_name .
                  " where user_id = ".$this->user_id;
        $stmt = $this->conn->prepare($query);
     
        // execute query
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    function discount() {
        $query = "Select SUM(total_discount) as total_discount from " . $this->table_name .
                  " where user_id = ".$this->user_id;
        $stmt = $this->conn->prepare($query);
     
        // execute query
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    function total_tax() {
        $query = "Select SUM(total_tax) as total_tax from " . $this->table_name .
                  " where user_id = ".$this->user_id;
        $stmt = $this->conn->prepare($query);
     
        // execute query
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }
    
}    
?>

<!-- curl -X DELETE localhost/api/cart/delete.php -->
