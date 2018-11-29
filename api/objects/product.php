<?php
class Product {
 
    private $conn;
    private $table_name = "products";
 
    public $id;
    public $name;
    public $description;
    public $price;
    public $discount;
    public $category_id;
    public $category_name;
    public $created;
 
    function __construct($db){
        $this->conn = $db;
    }

	function read() {
	 
	    $query = "SELECT
	                c.name as category_name, p.id, p.name, p.description, p.price, p.discount, p.category_id, p.created
	            FROM
	                " . $this->table_name . " p
	                LEFT JOIN
	                    categories c
	                        ON p.category_id = c.id
	            ORDER BY
	                p.created DESC";
	 
	    $stmt = $this->conn->prepare($query);
	 
	    $stmt->execute();
	 
	    return $stmt;
	}

	function create(){
 
	    $query = "INSERT INTO
	                " . $this->table_name . "
	            SET
	                name= :name, price= :price, description= :description, category_id= :category_id,discount= :discount, created= :created";
	 
	    $stmt = $this->conn->prepare($query);
	 
	    $stmt->bindParam(":name", $this->name);
	    $stmt->bindParam(":price", $this->price);
	    $stmt->bindParam(":description", $this->description);
	    $stmt->bindParam(":category_id", $this->category_id);
	    $stmt->bindParam(":created", $this->created);
	    $stmt->bindParam(":discount", $this->discount);
	 
	    if($stmt->execute()){
	        return true;
	    }
	 
	    return false;
	     
	}

	function readOne(){
	 
	    $query = "SELECT
	                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
	            FROM
	                " . $this->table_name . " p
	                LEFT JOIN
	                    categories c
	                        ON p.category_id = c.id
	            WHERE
	                p.id = ?
	            LIMIT
	                0,1";
	 
	    $stmt = $this->conn->prepare( $query );
	    $stmt->bindParam(1, $this->id);
	    $stmt->execute();
	 
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
	    $this->name = $row['name'];
	    $this->price = $row['price'];
	    $this->description = $row['description'];
	    $this->category_id = $row['category_id'];
	    $this->category_name = $row['category_name'];
	}

	function update(){
	    $query = "UPDATE
	                " . $this->table_name . "
	            SET
	                name = :name,
	                price = :price,
	                description = :description,
	                category_id = :category_id
	            WHERE
	                id = :id";
	 
	    $stmt = $this->conn->prepare($query);
	    $stmt->bindParam(':name', $this->name);
	    $stmt->bindParam(':price', $this->price);
	    $stmt->bindParam(':description', $this->description);
	    $stmt->bindParam(':category_id', $this->category_id);
	    $stmt->bindParam(':id', $this->id);
	 
	    if($stmt->execute()){
	        return true;
	    }
	    return false;
	}

	function delete_all() {

	    $query = "DELETE FROM " . $this->table_name;
	    $stmt = $this->conn->prepare($query);
	 
	    // execute query
	    if($stmt->execute()){
	        return true;
	    }
	 
	    return false;
	}

	function delete(){

	    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
	    $stmt = $this->conn->prepare($query);
	 
	    $stmt->bindParam(1, $this->id);
	 
	    if($stmt->execute()){
	        return true;
	    }
	    return false;
	}
}
?>
