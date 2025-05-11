<?php

session_start();
require_once("include.php");

$_SESSION["last_page"]="file.php";
	
if(!isset($_SESSION["user"]) || $_SESSION["user"] != "admin"){
	
	echo '<a href = "login.php"> login</a>'; 
	echo '<br/>';
	
	
}else{

	
	echo '<a href = "logout.php?logout=yes"> logout</a>';
	echo '<br/>';
}

echo ' <a href="type.php" >Retour</a>';
echo ' <br/>';

if(isset($_GET["type"])){
	
	if(in_array($_GET["type"],$types)){//check if the type exist;
	$_SESSION["type"] = $_GET["type"];
	}else{die("type n'exist pas");} // if the type not exist stop the script;
}



if(isset($_SESSION["type"],$_SESSION["module"],$_SESSION["id_module"])){// check first if the information exist in the session to execute the script
	
	$type = $_SESSION["type"];
	$module=$_SESSION["module"];
	$id_module = $_SESSION["id_module"];
	
	//bring the files from database
	
	$sql ="select * from file where id_module = '$id_module' AND type = '$type'";
	$result = mysqli_query($connect,$sql);
	
	if(!$result){
		
		die(mysqli_error($connect));
		
	}else{
		echo htmlspecialchars($module);
		echo'<br/>';
		echo htmlspecialchars($type);
		echo'<br/>';
		if(isset($_SESSION["user"])){//if the user is admin add option to add files
			
			echo "<a href='#' onclick=\"document.getElementById('file').click(); return false;\">َADD</a>";
			echo"<form id='uploadForm' name='sent' action='upload.php' method='post' enctype='multipart/form-data'>
				<input type='file' id='file' name='files[]' multiple='multiple' style=\"display: none;\"  onchange='document.getElementById(\"uploadForm\").submit();'>
				</form>";
			
		}
		
		
		if(mysqli_num_rows($result)>0){//execute only if file exist
			while($res = mysqli_fetch_assoc($result)){
				
				
				
				$name= substr($res["path"],5);//remove the first 5 letters in path (data/);
				$path = $res["path"];
				
				echo "<a href='".$path."' target='_blank' >".$name. "  </a>";
				echo "<br/>";
				echo "<a href='".$path."' download='".$name."' title='download the file'>Download</a>";
				echo "<br/>";
				if(isset($_SESSION["user"])){//add option to delete file if the user is admin
					$id_file = $res["id_file"];
					echo "<a href='delete_file.php?id_file=".$id_file."'  >Del</a>";
					echo "<br/>";
				}	
			}
		}else{//if no file exist
				echo"NO File Exist";
		}
	
	}
}else{header("location:index.php");exit;}//if no information exist in the session return to the first page

?>

