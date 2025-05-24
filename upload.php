<?php
session_start();

// Disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once("include.php");


echo ' <a href="file.php" >Retour</a>';
echo ' <br/>';

if(isset($_SESSION["user"]) && $_SESSION["user"] == "admin"){//check the user

	if(isset($_FILES["files"])){
		
		$id_module = $_SESSION["id_module"];
		$type = $_SESSION["type"];
		$total_files = count($_FILES['files']['name']);//count the number of files uploaded
		
		for($i=0;$i<$total_files;$i++){
		
			$upload_dir = "data/";
			$original_name = $_FILES["files"]["name"][$i];
			$ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
			$uniq_name = uniqid("file_", true) . '.' . $ext;
			$target_path = $upload_dir . $uniq_name;
			if(move_uploaded_file($_FILES["files"]["tmp_name"][$i],$target_path)){//verify if the file saved successfully
				//insert file information into the database
				$file = mysqli_real_escape_string($connect,$target_path);
				$sql = "INSERT INTO `file`( id_module, `type`, `path`,`original_name` ) VALUES ('$id_module','$type','$target_path','$original_name')";
				$result = mysqli_query($connect,$sql);
				if(!$result){
					
					die("fail to  upload $file_name " . mysqli_error($connect));
				}
					
			}else{die("fail to upload file");}
		
		}
		header("location: file.php");
		exit;
					 
			
	}else{echo"NO FILE SELECTED";}

}else{echo"this page only for admin";}


?>