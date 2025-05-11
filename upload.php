<?php
session_start();
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
			$file_name = $_FILES["files"]["name"][$i];
			$target_path = $upload_dir . $file_name;
			if(move_uploaded_file($_FILES["files"]["tmp_name"][$i],$target_path)){//verify if the file saved successfully
				//insert file information into the database
				$file = mysqli_real_escape_string($connect,$target_path);
				$sql = "INSERT INTO `file`( id_module, `type`, `path` ) VALUES ('$id_module','$type','$target_path')";
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