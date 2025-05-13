<?php


require_once("include.php");


session_start();


if(isset($_POST["sent"])){//execute if submit is clicked
	
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	//bring the username and password from database for checking
	$sql = "select * from admin ";
	
	$result = mysqli_query($connect,$sql);
	
	if(!$result){//If an error occurs when bringing
		die( "ERROR" . mysqli_error($connect)); 
			
	}else{//if bringing successfully
		
		$res = mysqli_fetch_assoc($result);
		
		if($res["username"] == $username && password_verify($password,$res["password"])){//verify the username and password
			
			session_regenerate_id(true);
			$_SESSION["user"] = "admin";
			
			if(isset($_SESSION["last_page"])){

				header("location:".$_SESSION["last_page"]);

			}else{header("location:index.php");}
			
		}else{
			
			echo "username or password is wrong , try again ";
			echo "<br/>";
		}	
	}
	
}


if(isset($_SESSION["user"]) && $_SESSION["user"] == "admin"){
	
	echo "You're already logged in";
	
}else{
	
	?>
	
	<a href="index.php" >Retour</a>
	<br/>
	
	<form method ="post" >
	
		<label for ="username">username</label>
		<input type="text" id="username" placeholder="username" name="username" />
		<br/>
		
		<label for ="password" >password</label>
		<input type = "password" id="password" name="password" placeholder="password" />
		
		<br/>
		
		<input type="submit" name="sent" />
	
	</form>
	
<?php

		
}
?>