<?php

$connect = mysqli_connect("localhost","root","","cours");
if(!$connect){die (mysqli_error($connect));
}

$pages = ["index.php", "module.php","type.php","file.php"]; //array of the allowed pages
$types = ["Cours","Td","Tp","Exams"]; //array of the allowed types


function check_module($id_module , $connect) {
	
    $sql = "SELECT `nom_module`,id_module FROM `module` WHERE id_module = '$id_module' ";
	$result = mysqli_query($connect,$sql);
	if(!$result){
		die("Error" . mysqli_error($connect));
	}else{
	
		if(mysqli_num_rows($result)>0){
			
			$res = mysqli_fetch_assoc($result);
			return $res;
		}else{return false;}
	}
}


function check_file($connect,$id_file) {
	
    $sql = "SELECT path FROM file WHERE id_file = '$id_file'";
	$result = mysqli_query($connect,$sql);
	if(!$result){
		die("Error" . mysqli_error($connect));
	}
	
	if(mysqli_num_rows($result)>0){
		$res = mysqli_fetch_assoc($result);
		return $res["path"];
	}else{return false;}
}

function check_tp($connect,$id_module) {
	
    $sql = "SELECT tp_exist FROM module WHERE id_module = '$id_module'";
	$result = mysqli_query($connect,$sql);
	if(!$result){
		die("Error" . mysqli_error($connect));
	}
	
	if(mysqli_num_rows($result)>0){
		$res = mysqli_fetch_assoc($result);
		
		if($res["tp_exist"] == 1){
			
			return true;
			
		}elseif($res["tp_exist"] == 0){return false;}
		
	}else{
		return true;
	}
}


?>