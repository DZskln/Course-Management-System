<?php

session_start();


if(isset($_SESSION["user"]) && $_SESSION["user"] === "admin"){
	
	require_once("include.php");


	echo ' <a href="file.php" >Retour</a>';
	

	if(isset($_GET["id_file"])){
		
		if(ctype_digit($_GET["id_file"])){//check if the id is integer 
			
		
			$id_file = $_GET["id_file"];
			
			$path = check_file($connect,$id_file);//check if the file exist
			
			if($path){//if is true delete the file
			
				$sql="DELETE FROM `file` WHERE id_file='$id_file'";
				
				$result = mysqli_query($connect,$sql);
				
				if(!$result){
					
					die("delete fail".mysqli_error($connect));
					
				}else{//remove the file from the machine
					unlink($path);
					header("location:file.php");
					exit;	
				}	
		
			}else{header("location:index.php");exit;}
			
		}else{header("location:index.php");exit;}
		
	}else{header("location:index.php");exit;}

}else{header("location:index.php");exit;}

?>