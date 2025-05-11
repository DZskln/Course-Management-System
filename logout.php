<?php

session_start();
require_once("include.php");

if(isset($_SESSION["last_page"])){
	
	if(!in_array($_SESSION["last_page"] , $pages)){ //check the last page session ; 
		
		unset($_SESSION["last_page"]); // if not validate unset the session ;
	}

}

if(isset($_SESSION["user"]) && $_SESSION["user"] === "admin"){ //check user , only for admine

	if($_SERVER["REQUEST_METHOD"] == "GET"){ //check the request methode 

		if(isset($_GET["logout"]) && $_GET["logout"] == "yes" ){ //check the value of get
			
			?>
				<html>
				<head>
				<title> Logout </title>

				</head>
				<body>

				<form action='logout.php' method='post'  >

				<p>Do you want to log out?</p>
				
				<br/>
				<input type='submit' value='Yes'  name='yes' />
				<input type='submit' value='No'  name='no' />
				</form>

				</body>

				</html>
			
			<?php	
		}else{header("location:index.php");exit;}//execute if the user changed the get value in url;
	}
	
	if(isset($_POST["yes"])){
		
		//unset the session[user];
		
		
		unset($_SESSION["user"]);
		
		if(isset($_SESSION["last_page"])){ //if the last page exist in the session;

			header("location:".$_SESSION["last_page"]);
			exit;

		}else{header("location: index.php");exit;} // else redirect into the page index;
		
	}
	
	if(isset($_POST["no"])){
		
		
		if(isset($_SESSION["last_page"])){ //if the last page exist in the session;

			header("location:".$_SESSION["last_page"]);
			exit;

		}else{header("location: index.php");exit;} // else redirect into the page index;
		
	}
	
	
}else{ // if the user not admine

	if(isset($_SESSION["last_page"])){ //if the last page exist in the session;

		header("location:".$_SESSION["last_page"]);
		exit;

	}else{header("location: index.php");exit;} // else redirect into the page index;
}



?>