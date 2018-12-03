<?php

$flag_image = $flage_document = 0;

function validateImage() {
    global $flag_image;
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 3MB maximum
        $maxsize = 3 * 1024 * 1024;
        // Changes the file_max_size in php.ini
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        if(in_array($filetype, $allowed)) {
            // Check whether file exists before uploading it
            if(file_exists("/home/webonise/Public/uploadImage/" . $filename)){
                echo $filename . " is already exists.";
            } 
            else {
                move_uploaded_file($_FILES["photo"]["tmp_name"], "/home/webonise/Public/uploadImage/" . $filename);
                echo "Your file was uploaded successfully.";
                $flag_image = 1;
            } 
        } 
        else {
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } 
    else {
        echo "Error: " . $_FILES["photo"]["error"];
    }
}

function validateDocument() {
    global $flage_document;
    if(isset($_FILES["document"]) && $_FILES["document"]["error"] == 0) {
        $filename = $_FILES["document"]["name"];
        $filesize = $_FILES["document"]["size"];
    
        $maxsize = 10 * 1024 * 1024;
        // Changes the file_max_size to 10MB in php.ini
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Check whether file exists before uploading it
        if(file_exists("/home/webonise/Public/uploadDoc/" . $filename)){
            echo $filename . " is already exists.";
        } 
        else {
            move_uploaded_file($_FILES["document"]["tmp_name"], "/home/webonise/Public/uploadDoc/" . $filename);
            echo "Your file was uploaded successfully.";
            $flage_document = 1;
            $my_file = "/home/webonise/Public/uploadDoc/" . $filename;
            $handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
            $data = 'Together we change the world, just one random act of kindness at a time';
            fwrite($handle, $data); 
            fclose($my_file);  
        } 
    } 
    else {
        echo "Error: " . $_FILES["document"]["error"];
    }
}

function createRecord() {
    include_once('pdo.php');
    $sql = "INSERT INTO Infos (title, image, document) VALUES ( :title, :image, :document)";

    if($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":title", $param_title);
        $stmt->bindParam(":image", $param_image);
        $stmt->bindParam(":document", $param_document);
        
        // Set parameters
        $param_title = $_POST["title"];
        $param_image = $_FILES["photo"]["name"];
        $param_document = $_FILES["document"]["name"];
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records created successfully. Redirect to landing page
            header("location: index.php");
            exit();
        } else{
            echo "Something went wrong. Please try again later.";
        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    
    validateImage();
    validateDocument();

    if( $flag_image && $flage_document ) {  // checks if image and documents get successfully uploaded
        createRecord();
    }
}
?>
