<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="./assets/Favicon.png">
	<link rel="stylesheet" href="./style/typeStyling.css">
	<title>Type</title>
</head>

<body>
	<div class="navContainer">
		<nav class="NavBar">
			<?php

			session_start();
			require_once("include.php");


			echo ' <a class="cta" href="module.php" >Retour</a>';

			$_SESSION["last_page"] = "type.php";


			if (isset($_GET["id_module"])) {

				if (!ctype_digit($_GET["id_module"])) { // check if the id is an integer;
					die("Error in id of the module"); // if in not integer stop the script;
				}

				$res = check_module($_GET["id_module"], $connect); // check if the module exist in database


				if ($res) {

					$_SESSION["id_module"] = $res["id_module"]; //save the id in the session;
					$_SESSION["module"] = $res["nom_module"]; // save the name of module in the session;

				} else {
					die("module not found");
				}
			}

			// this code is added by Rafie

			if (isset($_SESSION["module"], $_SESSION["id_module"])) { //check first if the information exist in the session to execute the script


				$module = $_SESSION["module"]; //Recover the name of module from the session;
				$id_module = $_SESSION["id_module"]; //Recover the id of module from the session;


				echo "<h1>" . htmlspecialchars($module) . "</h1>";
			} else {
				header("location:index.php");
				exit;
			}
			// code ends


			if (!isset($_SESSION["user"]) || $_SESSION["user"] !== "admin") {

				echo '<a class="cta logInButton" href = "login.php"> login</a>';
			} else {
				echo '<a class="cta logOutButton" href = "logout.php?logout=yes"> logout</a>';
			}
			?>

		</nav>
	</div>
	<div class="heroContainer">
		<div class="heroSubContainer">



			<?php

			if (isset($_SESSION["module"], $_SESSION["id_module"])) { //check first if the information exist in the session to execute the script


				$module = $_SESSION["module"]; //Recover the name of module from the session;
				$id_module = $_SESSION["id_module"]; //Recover the id of module from the session;

				// this code is commented by Rafie
				// echo htmlspecialchars($module);

				echo "<a class='cta typeCta coursCta' href='file.php?id_module=" . $id_module . "&type=Cours'  >Cours</a>";

				echo "<a class='cta typeCta tdCta' href='file.php?id_module=" . $id_module . "&type=Td'  >TD</a>";

				if (check_tp($connect, $id_module)) { //show only if tp exist
					echo "<a class='cta typeCta tpCta' href='file.php?id_module=" . $id_module . "&type=Tp'  >TP</a>";
				}

				echo "<a class='cta typeCta examsCta' href='file.php?id_module=" . $id_module . "&type=Exams'  >Exams</a>";
			} else {
				header("location:index.php");
				exit;
			} //if no information exist in the session return to the first page


			?>
		</div>
	</div>
</body>

</html>