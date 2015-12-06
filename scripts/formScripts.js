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
					alert("Error while processing the login..." + data);

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
		var privateEvent = $('select[name="privateEvent"]').val()
		//var privateEvent = document.forms["createEventForm"]["privateEvent"].value;
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
				'privateEvent' :privateEvent,
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

        		var antigoTitulo = $( ".Ftitle").text();

		        $.post(
		        'events/getSelectedId.php',
		        {
		            'antigoTitulo' : antigoTitulo
		        },
		        function(data){
		            $("#P"+data).css("background-color", "black");
		            $("#I"+data).css("background-color", "black");
		        });

		        

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
		                if($( "#eventInfo" ).is( ":visible" )){
		                    $("#P"+eventID).css("background-color", "black");
		                    $("#I"+eventID).css("background-color", "black");
		                }
		                else{
		                    $("#P"+eventID).css("background-color", "green");
		                    $("#I"+eventID).css("background-color", "green");
		                }


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
		            var people = data['people'];
            		var numberPeople = data['Npeople'];
		            var Fprivate = data['privateEvent'];

		            //highlight selected event
			        $("#P"+eventID).css("background-color", "green");
			        $("#I"+eventID).css("background-color", "green");

		            var go = data['attend'];

		            //alteração da informação do host
		            //no caso de ser o proprio user, aparece um botão para dar delete ao evento
		            if (host == "Delete Event"){
		                $( ".editEvent").show();
		                $( ".deleteEvent").text( host);
		                $( ".deleteEvent").show();
		                $( ".hostName").hide();
		                $( "#inviteP").show();
		            }
		            else{
		                $( ".hostName").text(host);
		                $( ".hostName").show();
		                $( ".deleteEvent").hide();
		                $( ".editEvent").hide();
		                $( "#inviteP").hide();
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

		            //se for host não aparece as opções going/not going
		            if (host == "Delete Event"){
		                $( ".FgoingT").hide();
		                $( ".FgoingF").hide();
		                $( ".FstopT").hide();
		                $( ".FstopF").hide();
		            }

		            $("#Fpeople").text(numberPeople + " people going.");
		            $("#FlistPeople").hide();
		            $("#FlistPeople").empty();
		            $("#FlistPeople").append('<p id="listTitle">List of people</p>');
		            for(var i = 0; i < numberPeople; i++){
		                var person = people[i]['username'];
		                $("#FlistPeople").append('<p>'+person+'</p>');
		            }
		            
		            //alteração de informação genérica
		            $( ".Ftitle" ).text( name);
		            $( ".Fdate" ).text( date);
		            $( ".Ftime").text( timeH);
		            $( ".Ftype").text(type);
		            $( ".Flocation" ).text( local);
		            $( ".Fdescription" ).text( description);
   		            $( ".FprivateEvent" ).text( local);
		            $( ".FeventImage" ).html( "<img src=" + image + " alt=" + "eventImage"+" />");

		            if(Fprivate == 0){
		                $(".FprivateEvent").text("Private");
		            }
		            else
		                $(".FprivateEvent").text("Public");
		            
		            //codigo para alteração de comentarios a apresentar
		            //array com informação relativa aos comentarios
		            var ComentaryArray = data['ArrayCom'];
		            $(".FcomUser").remove();
		            $(".FcomBody").remove();
		            $(".deleteComment").remove();
		            //apenas mostra os comentarios se o utilizador for ao evento
		            if (go){
		                 $("#Fcomments").show();
		                for(var j = 0; j < maxCom; j++){
		                    $("#Fcomments").append('<div class="FcomUser">' + ComentaryArray[2*j] + '</div>');
		                    if(host == "Delete Event" || data['session'] == ComentaryArray[2*j]){
		                         $("#Fcomments").append('<div id="deleteComment'+j+'" class="deleteComment" >delete</div>');
		                    }
		                    $("#Fcomments").append('<div class="FcomBody">' + ComentaryArray[2*j+1] + '</div>');
		                }
		            }
		            else{
		                $("#Fcomments").hide();
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

	
	$("#editEventForm").submit(function(ev){
		ev.preventDefault();

		var nameAntigo = document.forms["editEventForm"]["tituloAntigo"].value;
		var name = document.forms["editEventForm"]["titulo"].value;
		var date = document.forms["editEventForm"]["dateBegin"].value;
		var timeH = document.forms["editEventForm"]["time"].value;
		var type = document.forms["editEventForm"]["type"].value;
		var local = document.forms["editEventForm"]["location"].value;
		var description = document.forms["editEventForm"]["description"].value;
		var privateEvent = document.forms["editEventForm"]["privateEvent"].value;		
		var image = document.forms["editEventForm"]["image"].value;

		//verifica se o texto foi preenchido
		if (name == "" || date == "" || timeH == "" || type == "" || local == "" || description == "" || image == "") {
			alert("you didn't fill every field");
			return false;
		};

		$("#editEvent").hide();

		
		$.post(
        'events/editEvent.php',
        {
        	'antigoNome' : nameAntigo,
            'name' : name,
            'date' : date,
            'timeH' : timeH,
            'type' : type,
            'local' : local,
            'description' : description,
            'privateEvent' :privateEvent,
            'image' : image
        },
        function(data) {
        	switch(data){
        		case 'fail':
        		alert("failed to edit the event");
        		break;
        		case 'success':
        		location.reload();
        		break;
        		default:
        		alert(data);
        		break;
        	}

        }).fail(function(error) {
                return false;
        });  

	});

	$("#UserSettingsForm").submit(function(ev){
		ev.preventDefault();

		var name = document.forms["UserSettingsForm"]["oldname"].value;
		var username = document.forms["UserSettingsForm"]["username"].value;
		var pw = document.forms["UserSettingsForm"]["oldpw"].value;
		var newpw = document.forms["UserSettingsForm"]["newpw"].value;
		var newpw2 = document.forms["UserSettingsForm"]["newpw2"].value;

		//verifica se o texto foi preenchido
		if (name == ""){
			alert("the name can't be empty");
			return false;
		}
		else if (pw == ""){
			alert("insert password pls");
			return false;
		}
		$.post(
        'accounts/searchUser.php',
        {
        	'antigoNome' : name,
            'username' : username,
            'pw' : pw,
            'npw' : newpw,
            'npw2' : newpw2
        },
        function(data) {
        	switch(data){
        		case 'username_in_use':
        		alert("username already in use.");
        		break;
        		case 'name_changed':
        		alert("username changed successfully!");
        		location.reload();
        		break;
        		case 'fill_all_pw':
        		alert("you did not fill every necessary fields to change the password.");
        		break;
        		case 'passwords_not_match':
        		alert("passwords do not match.");
        		break;
        		case 'wrong_password':
        		alert("Wrong password.");
        		break;
        		case 'password_changed':
        		alert("password changed successfully!");
        		location.reload();
        		break;
        		default:
        		alert(data);
        		break;
        	}

        }).fail(function(error) {
                return false;
        });  

	});


	$("#DeleteAccForm").submit(function(ev){
		ev.preventDefault();

		var name = document.forms["DeleteAccForm"]["username"].value;
		var pw = document.forms["DeleteAccForm"]["pw"].value;
		var pw2 = document.forms["DeleteAccForm"]["pw2"].value;

		//verifica se o texto foi preenchido
		if (name == ""){
			alert("the name can't be empty");
			return false;
		}
		else if (pw == "" || pw2 == ""){
			alert("insert password twice pls");
			return false;
		}
		else if (pw != pw2){
			alert("passwords do not match");
			return false;
		}

		$.post(
        'accounts/delete.php',
        {
            'username' : name,
            'pw' : pw,
            'pw2' : pw2,
        },
        function(data) {
        	switch(data){
        		case 'wrong_password':
        		alert("wrong password");
        		break;
        		case 'RIP':
        		alert("Rest in Piece " + name);
        		$.post(
		        'accounts/logout.php',
		        {
		            
		        },
		        function(data) {
		            location.href='index.php?redirect=home';
		        }).fail(function(error) {
		                return false;
		        }); 
        		break;
        		default:
        		alert(data);
        		break;
        	}

        }).fail(function(error) {
                return false;
        });  

	});

	$("#inviteP").submit(function(ev){
		ev.preventDefault();

		var name = document.forms["inviteP"]["username"].value;
		var evento = $(".Ftitle").text();
		//verifica se o texto foi preenchido
		if (name == "") {
			return false;
		};

		var eventID;

		$.post(
        'accounts/invite.php',
        {
            'name' : name,
            'evento' : evento
        },
        function(data) {
        	switch(data){
        		case 'user_not_exit':
        		alert(name + " does not exist!");
        		break;
        		case 'fail':
        		alert("fail");
        		break;
        		case 'success':
        		alert(name + " invited successfully");
        		break;
        		default:
        		alert(data);
        		break;
        	}

        }).fail(function(error) {
                return false;
        });  

	});


})