<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./style/logoutStyling.css">
	<link rel="stylesheet" href="./style/delete_moduleStyling.css">
	<title>Delete Module Confirmation</title>
</head>

<body>







	<?php

	session_start();
	require_once("include.php");

	if (isset($_SESSION["user"]) && $_SESSION["user"] == "admin") {

		// this code commented with Rafie
		// echo ' <a href="module.php" >Retour</a>';


		if (isset($_GET["id_module"])) {

	?>
			<div class="heroContainer">
				<div class="heroSubContainer">
					<form action='delete_module.php' method='post'>

						<h1>Are Sure you want to delete the module ?</h1>
						<p class="warning">warning : all files inside the module are going to be deleted !</p>

						<div class="confiramtionButtons">
							<input type="hidden" value="<?= $_GET['id_module'] ?>" name="id_module" />
							<input class="cta logOutConfirmation" type='submit' value='Yes' name='Yes' />
							<input class="cta" type='submit' value='Retour' name='No' />
						</div>
					</form>
				</div>
			</div>
	<?php
		}

		if (isset($_POST["Yes"], $_POST["id_module"])) { //if the use confirm delete module

			$id_module = $_POST["id_module"];

			if (!ctype_digit($id_module)) { //check the id if is an integer; 
				die("Wrong id"); //stop the script if is not integer
			}


			// delete the file before delete the module

			$sql = "select * from file where id_module='$id_module'";
			$result = mysqli_query($connect, $sql);
			if (!$result) {
				die(mysqli_error($connect));
			} else {
				while ($res = mysqli_fetch_assoc($result)) {
					$path = $res["path"];
					unlink($path);
				}
			}

			//delete the module from database;
			$sql = "delete from module where id_module ='$id_module'";
			$result = mysqli_query($connect, $sql);
			if ($result) {

				header("location:module.php");
				exit;
			} else {
				die(mysqli_error($connect));
			}
		}

		if (isset($_POST["No"])) {

			header("location:module.php");
			exit;
		}
	} else {
		header("location:index.php");
		exit;
	} //execut if the user is not admin

	?>

</body>

</html>