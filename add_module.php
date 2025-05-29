<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="./assets/Favicon.png">
	<link rel="stylesheet" href="./style/add_ModuleStyling.css">
	<title> Add Module </title>
</head>

<body>

</body>

</html>



<?php


session_start();
// Disable caching
// header("Cache-Control: no-store, no-cache");

if (isset($_SESSION["user"]) && $_SESSION["user"] == "admin") {
	//check user first

	require_once("include.php");

	// this code is commented with Rafie
	// echo ' <a href="module.php" >Retour</a>';

	if (isset($_POST["ADD"], $_POST["module_name"], $_POST["tp_exist"])) {
		//save the information for later use

		$module_name = mysqli_real_escape_string($connect, $_POST["module_name"]); //for safety
		$tp_exist = $_POST["tp_exist"];
		$speciality = $_SESSION["speciality"];
		$année = $_SESSION["année"];
		$semester = $_SESSION["semester"];



		//verify if the module already exist in the same speciality and year;
		$sql = "select * from module where nom_module = '$module_name' AND id_sp = '$speciality' AND année = '$année'";
		$result = mysqli_query($connect, $sql);
		if (!$result) {
			die(mysqli_error($connect));
		} else {

			if (mysqli_num_rows($result) == 0) {

				//add the module to the databases
				$sql = "INSERT INTO `module`(`id_sp`, `année`, `nom_module`, `semester`,tp_exist) VALUES ('$speciality','$année','$module_name','$semester','$tp_exist')";
				$result = mysqli_query($connect, $sql);
				if (!$result) {
					//if error is happen stop the script

					die(mysqli_error($connect));
				} else {
					// if the module added successfully back to module page
					header("location:module.php");
				}
			} else {
				die("module already exist");
			}
		}
	}
} else {
	//if the user is not admin
	header("location:login.php");
	exit;
}

?>

<div class="heroContainer">
	<div class="heroSubContainer">
		<h1>Add New Module</h1>
		<form action='add_module.php' method='post'>
			<div class="inputField">
				<label for='module_name'>write module name</label>
				<input class="moduleInfo" type='text' id='module_name' name='module_name' placeholder="Module Name" />
			</div>


			<div class="inputField">
				<label for='tp_exist'>Are there Tp in this Module?</label>
				<select class="tpValidity" name='tp_exist' id='tp_exist'>
					<option value='1'>yes</option>
					<option value='0'>No</option>
				</select>
			</div>


			<div class="ctaContainers">
				
				<input class="cta addModuleButton" type='submit' value='ADD' name='ADD' />
				<a class="cta" href="module.php">Retour</a>
			</div>
		</form>


	</div>
</div>
</body>

</html>