<!DOCTYPE html>

<html>
  <head>
	<meta charset="UTF-8">
	<title>Events</title>
	<link rel="stylesheet" href="visual/home.css">
	<link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
 	<script src="scripts/formScripts.js"></script>  
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  </head>

	<body bgcolor="white">

		<!-- Login and register form. Both use submit scripts present in an jquery file-->
		<div id="forms">
			<h1>Events</h1>
			<div id="loginMenu" >
				<form action="/" name="loginForm" id="loginForm" method="post">
					<input type="text" placeholder="username" name="username">
					<input type="password" placeholder="password" name="pw">
					<input id="loginbutton" type="submit" value="Login">
				</form>
			</div>
			<div id="registerMenu" >
				<form action="/" name="registerForm" id="registerForm" method="post">
					<input type="text" placeholder="username" name="username">
					<input type="password" placeholder="password" name="pw">
					<input type="password" placeholder="repeat password" name="pw2">
					<input type="submit" value="Register">
				</form>
			</div>
		</div>

	</body>
</html>