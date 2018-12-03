<?php
require_once "pdo.php";

$sql = "SELECT * FROM Infos";
if($result = $pdo->query($sql)) {
    if($result->rowCount() > 0) {
        echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Title</th>";
                    echo "<th>Image</th>";
                    echo "<th>Document</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
	            while($row = $result->fetch()){
	                echo "<tr>";
	                    echo "<td>" . $row['id'] . "</td>";
	                    echo "<td>" . $row['title'] . "</td>";
	                    echo "<td>";
	                    	echo "/home/webonise/Public/uploadImage/".$row['image'];
	                    	echo "<img src= 'home/webonise/Public/uploadImage/".$row['image']."' width='50' height='50' />";
	                    echo "</td>";
	                    echo "<td>";
	                    	$path = "/home/webonise/Public/uploadDoc/". $row['document'];
	                    	$file = fopen($path, 'r') or die("can't open file");
	                    	$data = fread($file, filesize($path));
	                    	echo $data;
	                    	fclose($file);
	                    echo "</td>";
	                echo "</tr>";
	            }
            echo "</tbody>";                            
        echo "</table>";
        unset($result);
    } 
    else {
        echo "<p class='lead'><em>No records were found.</em></p>";
    }
} 
else {
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}

unset($pdo);
?>
