<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="./assets/Favicon.png">
	<link rel="stylesheet" href="./style/fileStyling.css">
	<title>Documents</title>
</head>

<body>
	<div class="navContainer">
		<nav class="NavBar">

			<?php

			session_start();
			require_once("include.php");
			echo ' <a class="cta" href="type.php" >Retour</a>';

			$_SESSION["last_page"] = "file.php";

			if (isset($_GET["type"])) {
				//check if the type exist;
				if (in_array($_GET["type"], $types)) {
					$_SESSION["type"] = $_GET["type"];
				} else {
					// if the type not exist stop the script;
					die("type n'exist pas");
				}
			}


			$type = $_SESSION["type"];
			$module = $_SESSION["module"];
			echo "<h1>" . htmlspecialchars($module) . " " . htmlspecialchars($type) . "</h1>";







			if (!isset($_SESSION["user"]) || $_SESSION["user"] != "admin") {
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


			// check first if the information exist in the session to execute the script
			if (isset($_SESSION["type"], $_SESSION["module"], $_SESSION["id_module"])) {


				$type = $_SESSION["type"];
				$module = $_SESSION["module"];
				$id_module = $_SESSION["id_module"];

				//bring the files from database

				$sql = "select * from file where id_module = '$id_module' AND type = '$type'";
				$result = mysqli_query($connect, $sql);

				if (!$result) {
					die(mysqli_error($connect));
				} else {


					if (isset($_SESSION["user"])) {
						//if the user is admin add option to add files

						echo "<a class='addFileButton' href='#' onclick=\"document.getElementById('file').click(); return false;\">َ<img src='./assets/add_Module_Icon.png'></a>";
						echo "<form id='uploadForm' name='sent' action='upload.php' method='post' enctype='multipart/form-data'>
				<input type='file' id='file' name='files[]' multiple='multiple' style=\"display: none;\"  onchange='document.getElementById(\"uploadForm\").submit();'>
				</form>";
					}


					if (mysqli_num_rows($result) > 0) { //execute only if file exist
						while ($res = mysqli_fetch_assoc($result)) {



							$name = $res["original_name"];
							$path = $res["path"];
							echo "<div class='unitCoursContainer'>";
							echo "<a class='fileNameIconContiner' href='" . $path . "' target='_blank' ><img src='./assets/file_Icon.png'><p>" . $name . "</p></a>";
							echo "<div class='downloadDeleteIconsContainer'>";
							echo "<a class='downloadIconContainer' href='" . $path . "' download='" . $name . "' title='download the file'><img src='./assets/download_Icon.png'></a>";

							if (isset($_SESSION["user"])) { //add option to delete file if the user is admin
								$id_file = $res["id_file"];
								echo "<a class='deleteIconContainer' href='delete_file.php?id_file=" . $id_file . "'  ><img src='./assets/delete_Icon.png'></a>";
							}
							echo "</div>";
							echo "</div>";
						}
					} else { //if no file exist
						echo "NO File Exist";
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