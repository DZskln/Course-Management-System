<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="./assets/Favicon.png">
	<link rel="stylesheet" href="./style/moduleStyling.css">
	<title> Chose Module </title>

</head>


<body>
	<div class="navContainer">


		<nav class="NavBar">

			<!-- php Starts -->

			<?php

			session_start();

			require_once("include.php");

			$_SESSION["last_page"] = "module.php";


			echo ' <a class="cta" href="index.php" >Retour</a>';

			echo '<h1>Modules</h1>';

			if (!isset($_SESSION["user"]) || $_SESSION["user"] != "admin") {

				echo '<a class="cta logInButton" href = "login.php"> login</a>';
			} else {


				echo '<a class="cta logOutButton" href = "logout.php?logout=yes"> logout</a>';
			}

			?>
			<!-- php ends -->



		</nav>
	</div>

	<div class="heroContainer">
		<div class="heroSubContainer">


			<!-- php starts -->
			<?php


			if (isset($_POST["sent"])) { //Receiving the necessary information to the session 

				$_SESSION["speciality"] = $_POST["speciality"];
				$_SESSION["année"] = $_POST["année"];
				$_SESSION["semester"] = $_POST["semester"];
			}
			if (isset($_SESSION["speciality"], $_SESSION["année"], $_SESSION["semester"])) { //check first if the information exist in the session to execute the script

				$speciality = $_SESSION["speciality"];
				$année = $_SESSION["année"];
				$semester = $_SESSION["semester"];

				//bring the modules related to this information

				$sql = "select id_module ,nom_module  from module where id_sp='$speciality' AND année = '$année' AND semester ='$semester'";
				$result = mysqli_query($connect, $sql);

				if (!$result) { //stop the code if an error is happening

					die("No module selected" . mysqli_error($connect));
				} else { //execute if no error is happen


					if (mysqli_num_rows($result) > 0) { //verify first if a module exist related to the information
						

						while ($res = mysqli_fetch_assoc($result)) { //show all module related to the information
							echo "<div class='unitModuleContainer'>";
							echo "<a class='moduleNameIconContainer' href='type.php?id_module=" . $res["id_module"] . "'><img src='./assets/folder_Icon.png'><p>" . htmlspecialchars($res["nom_module"]) . "</p></a>";

							if (isset($_SESSION["user"])) { //if the user is admin add a option to delete the module

								echo "<a class='deleteIconContainer' href='delete_module.php?id_module=" . $res["id_module"] . "'><img src='./assets/delete_Icon.png'></a>";
							}
							echo "</div>";
						}
					} else {
						echo "NO Module exist";
					} // executes if no module exist in database


					if (isset($_SESSION["user"]) && $_SESSION["user"] == "admin") { //if the user is admin add a option to add module

						echo "<a class='addModuleButton unitModuleContainer' href = 'add_module.php'> <img src='./assets/add_Module_Icon.png'></a>";
						
					}
				}
			} else {
				header("location:index.php");
				exit;
			} //if no information exist in the session return to the first page




			?>
			</div>	
		</div>
</body>
</html>