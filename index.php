<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "task";

 // Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$statusMsg = '';

// File upload path
$targetDir = "uploads/";

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if(isset($_POST["submit"]) && !empty($_FILES["image"]["name"])){
print_r('up to here');
	$fileName = basename($_FILES["file"]["name"]);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

echo "";
  
?>

<!DOCTYPE html> 
  <html> 
     <head> 
        <meta charset='utf-8'> 
        <title>BASIC CRUD OPERATION</title>
    <link rel='stylesheet' href='stylesheet.css' type='text/css'>
     </head>
 <body>
    <div class='box'>
    <center>
		<form action='upload.php' method='post' enctype="multipart/form-data">
	       Title<br /> <br>
	       <input type='text' name='title' class='form'/>
	       <br />
	       <br>
	       Description<br /> 
	       <br>
	       <textarea id="w3review" name="description" rows="4" cols="50"> </textarea><br><br>
	       &nbsp;&nbsp;&nbsp;<input type='file' name='file' class='form'/><br><br>
	       <input type='submit' value='Submit' class='button' />
			</form>
	    </form>
    </center>
    
    </div>
 </body>
  </html>