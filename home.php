<!DOCTYPE html>

<html>
  <head>
	<meta charset="UTF-8">
	<title>Events</title>
	<link rel="stylesheet" href="home.css">
	<link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
  </head>

	<body bgcolor="white">

		<div id="forms">
			<h1>Events</h1>
			<div id="loginMenu" >
				<form id="loginForm" method="post" action="cenas.php">
				<input type="text" placeholder="username" name="username">
				<input type="password" placeholder="password" name="pw">
				<input id="loginbutton" type="submit" value="Login">
			</div>
			<div id="registerMenu" >
				<form id="loginForm" method="post">
				<input type="text" placeholder="username" name="username">
				<input type="password" placeholder="password" name="pw">
				<input type="password" placeholder="repeat password" name="pw2">
				<input type="submit" value="Register">
			</div>
		</div>

	</body>
</html>