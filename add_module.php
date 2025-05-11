<?php


session_start();

if(isset($_SESSION["user"]) && $_SESSION["user"] == "admin"){//check user first
	
	require_once("include.php");
	
	echo ' <a href="module.php" >Retour</a>';
	echo'<br/>';	
	if(isset($_POST["ADD"],$_POST["module_name"],$_POST["tp_exist"])){//save the information for later use
		
		$module_name = mysqli_real_escape_string($connect, $_POST["module_name"]);//for safety
		$tp_exist = $_POST["tp_exist"];
		$speciality = $_SESSION["speciality"];
		$année = $_SESSION["année"];
		$semester = $_SESSION["semester"];
		
		
		
		//verify if the module already exist in the same speciality and year;
		$sql = "select * from module where nom_module = '$module_name' AND id_sp = '$speciality' AND année = '$année'";
		$result = mysqli_query($connect,$sql);
		if(!$result){
			die(mysqli_error($connect));
		}else{
			
			if(mysqli_num_rows($result)==0){
				
				//add the module to the databases
				$sql = "INSERT INTO `module`(`id_sp`, `année`, `nom_module`, `semester`,tp_exist) VALUES ('$speciality','$année','$module_name','$semester','$tp_exist')";
				$result = mysqli_query($connect,$sql);
				if(!$result){//if error is happen stop the script
					
					die(mysqli_error($connect));
					
				}else {header("location:module.php");}// if the module added successfully back to module page
				
				
			}else{die("module already exist");}
			
		}
	}


	
}else{echo"this page for only admin";}//if the user is not admin

?>
<html>
<head>
<title> ADD_Module </title>

</head>
<body>




<form action='add_module.php' method='post'  >

<label for='module_name' >write module name</label>
<input  type='text' id='module_name'  name='module_name' />

<br/>
<label for='tp_exist' >Are there Tp in this Module?</label>
<select name='tp_exist' id='tp_exist'>
<option value='1' >yes</option>
<option value='0' >No</option>
</select>
<br/>
<input type='submit' value='ADD'  name='ADD' />
</form>



</body>

</html>

