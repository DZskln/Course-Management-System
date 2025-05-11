<?php

session_start();
require_once("include.php");

if(isset($_SESSION["user"]) && $_SESSION["user"] == "admin"){
	
	
	echo ' <a href="module.php" >Retour</a>';
	echo'<br/>';
	
	if(isset($_GET["id_module"])){
		
		?>
			<html>
			<head>
			<title> delete module </title>

			</head>
			<body>

			<form action='delete_module.php' method='post'  >

			<p>Are Sure you want to delete the module ?</p>
			<p>warning : all filles of the module will be deleted !</p>
			
			<br/>
			<input type="hidden" value="<?=$_GET['id_module']?>" name="id_module"   /> 
			<input type='submit' value='Yes'  name='Yes' />
			<input type='submit' value='NO'  name='No' />
			</form>



			</body>

			</html>
		
		<?php
	}
	
	if(isset($_POST["Yes"],$_POST["id_module"])){//if the use confirm delete module
		
		$id_module = $_POST["id_module"];
		
		if(!ctype_digit($id_module)){ //check the id if is an integer; 
			die("Wrong id"); //stop the script if is not integer
		}
		
		
		// delete the file before delete the module
		
		$sql="select * from file where id_module='$id_module'";
		$result = mysqli_query($connect,$sql);
		if(!$result){
			die(mysqli_error($connect));
		}else{
			while($res = mysqli_fetch_assoc($result)){
				$path = $res["path"];
				unlink($path);
			}
		}

		//delete the module from database;
		$sql = "delete from module where id_module ='$id_module'";
		$result = mysqli_query($connect,$sql);
		if($result){
			
			header("location:module.php");
			exit;
		}else{
			die(mysqli_error($connect));
		}
	}
	
	if(isset($_POST["No"])){
		
		header("location:module.php");
		exit;
		
	}
	
	
}else{header("location:index.php");exit;}//execut if the user is not admin

?>