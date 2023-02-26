<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'connectDB.php';


if (isset($_POST['login'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);

	if ($count == 1 && password_verify($password, $row['password'])) {
		$_SESSION['username'] = $username;
		header("Location: PtiWiki.php?op=read&amp;file=PageAccueil");
	} else {
		echo "<h2> Login failed. Invalid username or password.</h2>";
	}
}

?>

<html>

<body>
	<form method="post" action="login.php" style="width:fit-content; margin:100px auto;">
		<h2>LOGIN</h2>
		<label>username: </label>
		<input type="text" name="username" id="username"><br><br>
		<label>password: </label>
		<input type="password" name="password" id="password"><br><br>
		<button type="submit" name="login">Login</button>
		<a href=signup.php style='margin-left: 20px'>Signup</a>
	</form>

	<hr>
	<p><a href="PtiWiki.php?op=read&amp;file=PageAccueil">Accueil</a></p>

</body>

</html>