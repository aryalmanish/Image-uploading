<?php

$statusMsg = '';
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "task";

$targetDir = "uploads/";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task";

$title = '';
$description = '';
$image = '';
$result = [];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if(!empty($_FILES["file"]["name"])){
	$fileName = basename($_FILES["file"]["name"]);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)) {
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Insert image file name into database

            $sql = "INSERT INTO images (title, image, description, uploaded_on, status )
            VALUES ('".$_POST['title']."', '".$fileName."', '".$_POST['description']."', NOW(), '1' )";

            if ($conn->query($sql) === TRUE) {
            	$last_id = $conn->insert_id;
            	$sql = "SELECT title, image, description FROM images WHERE id='".$last_id."'";
				$result = mysqli_query($conn, $sql);
				if ($result->num_rows > 0) {
				  // output data of each row
				  while($row = $result->fetch_assoc()) {
				    echo "<center>000
				    The title is :- '" . $row["title"]. "' <br>
				     The description is:- '" . $row["description"]. "'<br>
				     The image is here  <img src='/uploads/".$row['image']."'>
				    </center>";
				  }
				} else {
				  echo "0 results";
				}
              echo "New record created successfully";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close(); 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

?>