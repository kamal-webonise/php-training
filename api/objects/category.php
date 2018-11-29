<?php
class Category {
 
    private $conn;
    private $table_name = "categories";
 
    public $id;
    public $name;
    public $description;
    public $created;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    function read() {
     
        $query = "SELECT
                    id, name, description, tax
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }

    function create() {

        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name= :name, description= :description, tax= :tax, created= :created";
     
        $stmt = $this->conn->prepare($query);
     
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":tax", $this->tax);
        $stmt->bindParam(":created", $this->created);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function delete() {

        $query = "DELETE FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
     
        if($stmt->execute()) {
            return true;
        }
     
        return false;
    }

    function update() {
        
        $query = "UPDATE " . $this->table_name . "
                SET
                    name = :name,
                    tax = :tax,
                    description = :description
                WHERE
                    id = :id";        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':tax', $this->tax);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
     
        return false;        
    }
}
?>
