<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="./assets/Favicon.png">
	<link rel="stylesheet" href="./style/indexStyling.css">
	<title> Home </title>

</head>

<body>
	<div class="navContainer">


		<nav class="NavBar">

			<h1>Courses Files Manager</h1>


			<?php

			session_start();

			$_SESSION["last_page"] = "index.php";

			if (!isset($_SESSION["user"]) || $_SESSION["user"] != "admin") { //check the user 
				//if user is admin add logout botton
				echo '<a class="cta logInButton" href = "login.php"> Login</a>';
			} else {
				//if user is not admin add login botton
				echo '<a class="cta logOutButton" href = "logout.php?logout=yes">Logout</a>';
			}

			?>


		</nav>
	</div>

	<div class="heroContainer">


		<form class="Formulaire" action="module.php" method="post">

			<div class="selectContainer">
				<label for="speciality">select your speciality</label>
				<select name="speciality" id="speciality">
					<option value="si">system d'information</option>
					<option value="dr">droit</option>
					<option value="ssi">securité system d'information</option>
				</select>
			</div>

			<div class="selectContainer">
				<label for="year">select your year</label>
				<select name="année" id="year">
					<option value="1">first year</option>
					<option value="2">second year</option>
					<option value="3">third year</option>
				</select>
			</div>

			<div class="selectContainer">
				<label for="semester">select semester</label>
				<select name="semester" id="semester">
					<option value="1">semester 1</option>
					<option value="2">semester 2</option>

				</select>
			</div>

			<input class="cta" type="submit" name="sent" value="Continue" />


		</form>
	</div>


</body>

</html>