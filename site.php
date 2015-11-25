<!DOCTYPE html>

<html>
  <head>
	<meta charset="UTF-8">
	<title>Events</title>
	<link rel="stylesheet" href="site.css">
  </head>

	<body bgcolor="white">
		<div id="header">
			<h2>Alpha v0.005</h2>
			<h1>Events</h1>
		</div>
		<div id="menu">
			<ul>
				<li><a href="registar.php">Register</a></li>
				<li><a href="criarEvento.html">Create event</a></li>
			</ul>
			<div id="loginMenu" style="display: inline;">
				<?php
					if(date("H") < 23){
		   				echo'<form id="loginForm" style="display: inline;" action="printUsers.php">
						Username/Password: <input type="text" name="username">
						<input type="password" name="pw">
						<input type="submit" value="Login">';
					}
					else{
						echo '<div id=loged>LogedIn</div>';
					}
				?>
			</div>
		</div>
		<div id="FirstBoxes"> 
			
			<div id="procurar_eventos">
				<h1> Search Events </h1>
				<form action="pesquisaEventos.php">
				Name:<br><input type="text" name="nomeEvento"><br>
				Local:<br><input type="text" name="local"><br>
				Date:<br><input list="data" name="data">
					<datalist id="data">
						<option value="Today">
						<option value="Tomorrow">
						<option value="This week">
						<option value="This month">
						<option value="Ever">
					</datalist>
				<br><br><input type="submit" value="Search"><br><br>
			</form>
			</div>
		</div>
	</body>
</html>