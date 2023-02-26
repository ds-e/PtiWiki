<?php

session_start();

include 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$hash = password_hash($password, PASSWORD_DEFAULT);

	$query = "insert into users (username,compte,password) values('$username', 'user', '$hash')";

	if (!empty($username) && !empty($password)) {

		$select = mysqli_query($conn, "SELECT * FROM users WHERE username = '" . $_POST['username'] . "'");

		if (mysqli_num_rows($select)) {
			echo "<h2> Username taken, choose a different one. </h2>";
		} 
		else {
			mysqli_query($conn, $query);
			mysqli_close($conn);
			$_SESSION = array();
			session_destroy();
			header("Location: PtiWiki.php?op=read&amp;file=PageAccueil");
		}
	} else {
		echo "Please fill in both fields";
	}
}
?>

<html>

<body>
	<form method="post" action="signup.php" style="width:fit-content; margin:100px auto;">
		<h2>SIGN UP</h2>
		<label>username: </label>
		<input type="text" name="username" id="username"><br><br>
		<label>password: </label>
		<input type="password" name="password" id="password"><br><br>
		<button type="submit">Sign up</button>
	</form>

	<hr>
	<p><a href="PtiWiki.php?op=read&amp;file=PageAccueil">Accueil</a></p>

</body>

</html>