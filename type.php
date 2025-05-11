<?php

session_start();
require_once("include.php");

$_SESSION["last_page"]="type.php";
	
if(!isset($_SESSION["user"]) || $_SESSION["user"] !== "admin"){
	
	echo '<a href = "login.php"> login</a>'; 
	echo '<br/>';
		
}else{
	echo '<a href = "logout.php?logout=yes"> logout</a>';
	echo '<br/>';
}


echo ' <a href="module.php" >Retour</a>';
echo ' <br/>';


if(isset($_GET["id_module"])){
	
	if(!ctype_digit($_GET["id_module"])){ // check if the id is an integer;
		die("Error in id of the module"); // if in not integer stop the script;
	}
	
	$res = check_module($_GET["id_module"],$connect); // check if the module exist in database
	
	
	if($res){
		
		$_SESSION["id_module"] = $res["id_module"]; //save the id in the session;
		$_SESSION["module"] = $res["nom_module"];// save the name of module in the session;
		
	}else{die("module not found");}
}

if(isset($_SESSION["module"],$_SESSION["id_module"])){//check first if the information exist in the session to execute the script
	
	
	$module = $_SESSION["module"];//Recover the name of module from the session;
	$id_module = $_SESSION["id_module"];//Recover the id of module from the session;
	
	
	echo htmlspecialchars($module);
	echo'<br/>';
	echo "<a href='file.php?id_module=".$id_module."&type=Cours'  >Cours</a>";
	echo'<br/>';
	echo "<a href='file.php?id_module=".$id_module."&type=Td'  >TD</a>";
	echo'<br/>';
	if(check_tp($connect,$id_module)){//show only if tp exist
		echo "<a href='file.php?id_module=".$id_module."&type=Tp'  >TP</a>";
		echo'<br/>';
	}
	
	echo "<a href='file.php?id_module=".$id_module."&type=Exams'  >Exams</a>";
	
}else{header("location:index.php");exit;}//if no information exist in the session return to the first page


?>