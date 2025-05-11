<?php

session_start();

$_SESSION["last_page"]="index.php";

if(!isset($_SESSION["user"]) || $_SESSION["user"] != "admin"){//check the user 
	//if user is admin add logout botton
	echo '<a href = "login.php"> login</a>'; 
	echo '<br/>';
}else{
	//if user is not admin add login botton
	echo '<a href = "logout.php?logout=yes">logout</a>';	
}

?>

<html>
<head>
<title> index </title>

</head>
<body>


<form action="module.php" method="post"  >

<label for="speciality" >select your speciality</label>
<select name="speciality" id="speciality">
<option value="si" >system d'information</option>
<option value="dr" >droit</option>
<option value="ssi" >securité system d'information</option>
</select>
<br/>

<label for="year" >select your year</label>
<select name="année" id="year">
<option value="1" >first year</option>
<option value="2" >second year</option>
<option value="3" >third year</option>
</select>
<br/>
<label for="semester" >select semester</label>
<select name="semester" id="semester">
<option value="1" >semester 1</option>
<option value="2" >semester 2</option>

</select>

<br/>
<input type="submit"  name="sent" />


</form>


</body>

</html>