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

	$("#searchEvent").submit(function(ev){
		ev.preventDefault();

		var name = document.forms["searchEvent"]["name"].value;

		//verifica se o texto foi preenchido
		if (name == "") {
			return false;
		};

		var eventID;

		$.post(
        'events/search.php',
        {
            'name' : name
        },
        function(data) {
        	if (data == "fail"){
        		return false;
        	}
        	else{
        		eventID = data;

        		$.post(
		        'events/getEventInfo.php',
		        {
		            'id' : eventID
		        },
		        function(data) {
		            data=JSON.parse(data);
		            var name = data['name'];

		            //quando se carrega no mesmo evento ele esconde-se 
		            if ($( ".Ftitle" ).text() == name){
		                $("#eventInfo").toggle();
		                return false;
		            }
		            $("#eventInfo").hide();

		            var date = data['dateBegin'];
		            var local = data['location'];
		            var description = data['description'];
		            var image = data['image'];
		            var host = data['host'];
		            var tableCom = data['tableCom'];
		            var maxCom = data['maxCom'];
		            var timeH = data['time'];
		            var type = data['type'];

		            var go = data['attend'];

		            //alteração da informação do host
		            //no caso de ser o proprio user, aparece um botão para dar delete ao evento
		            if (host == "Delete Event"){
		                $( ".deleteEvent").text( host);
		                $( ".deleteEvent").show();
		                $( ".hostName").hide();
		            }
		            else{
		                $( ".hostName").text(host);
		                $( ".hostName").show();
		                $( ".deleteEvent").hide();
		            }

		            if(go){
		                $( ".FgoingT").show();
		                $( ".FgoingF").hide();
		                $( ".FstopT").hide();
		                $( ".FstopF").show();
		            }
		            else{
		                $( ".FgoingT").hide();
		                $( ".FgoingF").show();
		                $( ".FstopT").show();
		                $( ".FstopF").hide();
		            }
		            
		            //alteração de informação genérica
		            $( ".Ftitle" ).text( name);
		            $( ".Fdate" ).text( date);
		            $( ".Ftime").text( timeH);
		            $( ".Ftype").text(type);
		            $( ".Flocation" ).text( local);
		            $( ".Fdescription" ).text( description);
		            $( ".FeventImage" ).html( "<img src=" + image + " alt=" + "eventImage"+" />");
		            
		            //codigo para alteração de comentarios a apresentar
		            //array com informação relativa aos comentarios
		            var ComentaryArray = data['ArrayCom'];
		            $(".FcomUser").remove();
		            $(".FcomBody").remove();
		            //se não houver comentários, dá replace com divs vazios
		            for(var j = 0; j < maxCom; j++){
		                $("#Fcomments").append('<div class="FcomUser">' + ComentaryArray[2*j] + '</div>');
		                $("#Fcomments").append('<div class="FcomBody">' + ComentaryArray[2*j+1] + '</div>');
		            }

		            $("#eventInfo").show( "slow");

		        }).fail(function(error) {
		                return false;
		        });     





        	}
        }).fail(function(error) {
                return false;
        });  

	});

})