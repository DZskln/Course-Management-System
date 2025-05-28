<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="./assets/Favicon.png">
	<link rel="stylesheet" href="./style/loginStyling.css">
	<title>Log In</title>
</head>

<body>







	<?php


	require_once("include.php");


	session_start();


	if (isset($_POST["sent"])) { //execute if submit is clicked

		$username = $_POST["username"];
		$password = $_POST["password"];

		//bring the username and password from database for checking
		$sql = "select * from admin ";

		$result = mysqli_query($connect, $sql);

		if (!$result) { //If an error occurs when bringing
			die("ERROR" . mysqli_error($connect));
		} else { //if bringing successfully

			$res = mysqli_fetch_assoc($result);

			if ($res["username"] == $username && password_verify($password, $res["password"])) { //verify the username and password

				session_regenerate_id(true);
				$_SESSION["user"] = "admin";

				if (isset($_SESSION["last_page"])) {

					header("location:" . $_SESSION["last_page"]);
				} else {
					header("location:index.php");
				}
			} else {
				// this code is editted by Rafie
				// echo "username or password is wrong , try again ";
				$wrongInfoMsg = "username or password is wrong, Try again ";
			}
		}
	}


	if (isset($_SESSION["user"]) && $_SESSION["user"] == "admin") {

		echo "You're already logged in";
	} else {

	?>


		<div class="heroContainer">
			<div class="heroSubContainer">
				<h1>Admin Log in</h1>
				<form method="post">
					<div class="inputField">
						<label for="username">Username</label>
						<input class="adminInfo usernameField" type="text" id="username" placeholder="Username" name="username" />
					</div>

					<div class="inputField">
						<label for="password">Password</label>
						<input class="adminInfo passwordField" type="password" id="password" name="password" placeholder="Password" />
					</div>

					<?php
					if (isset($wrongInfoMsg)) {
						echo "<p class='wrongInfoMsg' >$wrongInfoMsg</p>";
					}

					?>

					<div class="ctaContainers">
						<input class="cta loginButton" value="Log in" type="submit" name="sent" />
						<?php
						if (isset($_SESSION["last_page"])) {
							$lastpage = $_SESSION["last_page"];
						} else {
							$lastpage = "index.php";
						}
						echo "<a class='cta'  href='$lastpage' >Retour</a>";
						?>
					</div>
				</form>
			</div>
		</div>

	<?php


	}
	?>

</body>

</html>