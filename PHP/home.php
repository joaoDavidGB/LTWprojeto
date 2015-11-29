<!DOCTYPE html>

<html>
  <head>
	<meta charset="UTF-8">
	<title>Events</title>
	<link rel="stylesheet" href="CSS/home.css">
	<link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
  </head>

	<body bgcolor="white">

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
		
		<script>
			$("#loginForm").submit(function(ev){
			    ev.preventDefault();

			    var username = document.forms["loginForm"]["username"].value;
			    var password = document.forms["loginForm"]["pw"].value;

			    if (password == "" || username == "") {
			        alert("You didn't fill either username or password");
			        return false;
			    };

			    console.log("antesdecenas");

			    $.post(
			        'accounts/login.php',
			        {
			        'username' : username,
			        'pw' : password
			        },
			        function(data) {
			            var response = data;
			            switch(response) {
			                case 'login_false':
			                    alert("Oops... Something went wrong!");
			                    break;
			                case 'login_true':
			                    console.log("Logined in successfully");
			                    location.href='index.php?redirect=site';
			                    break;
			                default:
			                	console.log("response: " + response);
			                    //displayError("Error while processing the login...");
			                    break;
			            }
			    	}).fail(function(error) {
			    			alert("wtf is going on?");
			                return false;
			    });              
			});

			$("#registerForm").submit(function(ev){
			    ev.preventDefault();

			    var username = document.forms["registerForm"]["username"].value;
			    var password = document.forms["registerForm"]["pw"].value;
			    var password2 = document.forms["registerForm"]["pw2"].value;

			    if (password == "" || username == "") {
			        alert("You didn't fill either username or password");
			        return false;
			    };

			    if (password != password2){
			    	alert("The passwords do not match!");
			    	return false;
			    }

			    $.post(
			        'accounts/createUser.php',
			        {
			        'user' : username,
			        'pw' : password
			        },
			        function(data) {
			            var response = data['login'];
			            console.log(data);
			            switch(response) {
			                case 'login_false':
			                    alert("Oops... Something went wrong!");
			                    break;
			                case 'login_true':
			                    alert("Logined in successfully");
					    location.href='index.php?redirect=site';
			                    break;
			                default:
			                    //displayError("Error while processing the login...");
			                    break;
			            }
			    	}).fail(function(error) {
			    			alert("wtf is going on?");
			                return false;
			    });              
			});
		</script>

	</body>
</html>