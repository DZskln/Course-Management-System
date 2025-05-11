<?php

session_start();

require_once("include.php");

$_SESSION["last_page"]="module.php";


	echo ' <a href="index.php" >Retour</a>';
	echo ' <br/>';
	
if(!isset($_SESSION["user"]) || $_SESSION["user"] != "admin"){
	
	echo '<a href = "login.php"> login</a>'; 
	echo '<br/>';
	
	
}else{

	
	echo '<a href = "logout.php?logout=yes"> logout</a>';
	echo '<br/>';
}


if(isset($_POST["sent"])){//Receiving the necessary information to the session 
	
	$_SESSION["speciality"]= $_POST["speciality"];
	$_SESSION["année"]= $_POST["année"];
	$_SESSION["semester"]= $_POST["semester"];
	
}
	if(isset($_SESSION["speciality"] , $_SESSION["année"] , $_SESSION["semester"])){//check first if the information exist in the session to execute the script
		
		$speciality = $_SESSION["speciality"];
		$année = $_SESSION["année"];
		$semester = $_SESSION["semester"];
		
		//bring the modules related to this information
	
		$sql = "select id_module ,nom_module  from module where id_sp='$speciality' AND année = '$année' AND semester ='$semester'";
		$result = mysqli_query($connect,$sql);
		
		if(!$result){//stop the code if an error is happening
			
			die("No module selected".mysqli_error($connect));
			
			
		}else{//execute if no error is happen
				
				
			if(mysqli_num_rows($result)>0){//verify first if a module exist related to the information
			
			
				while($res = mysqli_fetch_assoc($result)){//show all module related to the information
					
					echo "<a href='type.php?id_module=".$res["id_module"]."'>".htmlspecialchars( $res["nom_module"]) . "</a>";
					echo "<br/>";
					
					if(isset($_SESSION["user"])){//if the user is admin add a option to delete the module
						
						echo "<a href='delete_module.php?id_module=".$res["id_module"]."'>Del</a>";
						echo "<br/>";
					
					}
				}
				
			}else{echo "NO Module exist";}// execute if no module exist in database
			
			
			if(isset($_SESSION["user"]) && $_SESSION["user"] == "admin"){//if the user is admin add a option to add module
	
				echo '<a href = "add_module.php"> Add Module</a>'; 
				echo '<br/>';
			}
				
				
		}
			
		
	}else {header("location:index.php");exit;}//if no information exist in the session return to the first page




?>