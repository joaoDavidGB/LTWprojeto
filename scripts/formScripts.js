$("document").ready(function(){
	$("#loginForm").submit(function(ev){
		ev.preventDefault();

		//busca a informação necesária
		var username = document.forms["loginForm"]["username"].value;
		var password = document.forms["loginForm"]["pw"].value;
		//verifica se os campos foram preenchidos
		if (password == "" || username == "") {
			alert("You didn't fill either username or password");
			return false;
		};


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
					alert("Login failed!");
					break;
					case 'login_true':
					location.href='index.php?redirect=site';
					break;
					default:
					alert("Error while processing the login...");

					break;
				}
			}).fail(function(error) {
				alert("wtf is going on?");
				return false;
			});              
	});

	$("#registerForm").submit(function(ev){
		ev.preventDefault();

		//busca as informações importantes para registar o utilizador na base de dados
		var username = document.forms["registerForm"]["username"].value;
		var password = document.forms["registerForm"]["pw"].value;
		var password2 = document.forms["registerForm"]["pw2"].value;

		//verifica se os campos foram preenchidos
		if (password == "" || username == "") {
			alert("You didn't fill either username or password");
			return false;
		};
		//verifica se as passwords coincidem
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
				var response = data;

				switch(response) {
					case 'register_false':
					alert("Register failed");
					break;
					case 'register_true':
					//caso seja efetuado o registo com sucesso, efetua de seguida o login
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
								break;
								case 'login_true':
								location.href='index.php?redirect=site';
								break;
								default:
								alert("Error while processing the login...");

								break;
							}
						}).fail(function(error) {
							alert("wtf is going on?");
							return false;
						});      
						alert("Registered successfully");
						break;
						default:
						alert("Error while processing the register...");

						break;
					}
				}).fail(function(error) {
					alert("wtf is going on?");
					return false;
				});              
			});


	$("#createEventForm").submit(function(ev){
		ev.preventDefault();

		//busca as informações importnates para a criação de eventos
		var success = false;
		var name = document.forms["createEventForm"]["name"].value;
		var date = document.forms["createEventForm"]["dateBegin"].value;
		var time = document.forms["createEventForm"]["time"].value;
		var type = document.forms["createEventForm"]["type"].value;
		var location2 = document.forms["createEventForm"]["location"].value;
		var description = document.forms["createEventForm"]["description"].value;
		var image = document.forms["createEventForm"]["image"].value;

		//verifica se os campos foram preenchidos
		if (name == "" || date == "" || location == "" || description == "" || image == "") {
			alert("Fill every field before submiting.");
			return false;
		};


		$.post(
			'events/createEvent.php',
			{
				'name' : name,
				'date' : date,
				'time' : time,
				'type' : type,
				'location' : location2,
				'description' : description,
				'image' : image
			},
			function(data) {
				switch(data) {
					case 'failed_to_create_event':
					alert("failed to create the event!");
					break;
					case 'success':
					location.reload();
					break;
					default:
					alert(data);

					break;
				}
			}).fail(function(error) {
				alert("wtf is going on?");
				return false;
			});     
		});

	$("#addComment").submit(function(ev){
		ev.preventDefault();

		//busca as informações importantes para manipular a base de dados
		var eventName = ($(".Ftitle").text());
		var comment = document.forms["addComment"]["comment"].value;

		//verifica se o texto foi preenchido
		if (comment == "") {
			alert("You did not fill the comment field");
			return false;
		};


		$.post(
			'events/addComment.php',
			{
				'eventName' : eventName,
				'comment' : comment
			},
			function(data) {
				switch(data) {
					case 'failed_to_add_comment':
					alert("failed to add comment!");
					break;
					case 'success':
					location.reload();
					break;
					default:
					alert(data);

					break;
				}
			}).fail(function(error) {
				alert("wtf is going on?");
				return false;
			});     

	});

})