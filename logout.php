<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="./assets/Favicon.png">
	<link rel="stylesheet" href="./style/logoutStyling.css">
	<title>LogOut Confirmation</title>
</head>

<body>




	<?php

	session_start();
	require_once("include.php");

	if (isset($_SESSION["last_page"])) {

		if (!in_array($_SESSION["last_page"], $pages)) { //check the last page session ; 

			unset($_SESSION["last_page"]); // if not validate unset the session ;
		}
	}

	if (isset($_SESSION["user"]) && $_SESSION["user"] === "admin") { //check user , only for admine

		if ($_SERVER["REQUEST_METHOD"] == "GET") { //check the request methode 

			if (isset($_GET["logout"]) && $_GET["logout"] == "yes") { //check the value of get

	?>

				<div class="heroContainer">
					<div class="heroSubContainer">
						<h1>Do you want to log out?</h1>
						<form action='logout.php' method='post'>



							<!-- did you worked with the value or the name?? -->
							<!-- <input class="cta" type='submit' value='Yes' name='yes' />
							<input class="cta" type='submit' value='No' name='no' /> -->

							<input class="cta logOutConfirmation" type='submit' value='Log Out' name='yes' />
							<input class="cta" type='submit' value='Stay In' name='no' />
						</form>
					</div>
				</div>

	<?php
			} else {
				header("location:index.php");
				exit;
			} //execute if the user changed the get value in url;
		}

		if (isset($_POST["yes"])) {

			//unset the session[user];


			unset($_SESSION["user"]);

			if (isset($_SESSION["last_page"])) { //if the last page exist in the session;

				header("location:" . $_SESSION["last_page"]);
				exit;
			} else {
				header("location: index.php");
				exit;
			} // else redirect into the page index;

		}

		if (isset($_POST["no"])) {


			if (isset($_SESSION["last_page"])) { //if the last page exist in the session;

				header("location:" . $_SESSION["last_page"]);
				exit;
			} else {
				header("location: index.php");
				exit;
			} // else redirect into the page index;

		}
	} else { // if the user not admine

		if (isset($_SESSION["last_page"])) { //if the last page exist in the session;

			header("location:" . $_SESSION["last_page"]);
			exit;
		} else {
			header("location: index.php");
			exit;
		} // else redirect into the page index;
	}



	?>



</body>

</html>