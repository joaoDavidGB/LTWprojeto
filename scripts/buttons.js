$("document").ready(function(){
	$( ".listEvents" ).click(function(e) {
		
        //obtem a informação do evento clicado
		var eventID = e.currentTarget.id;
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
    });

    $( "#user" ).click(function() {
        //aparecimento das opções de utilizador
        $("#userOptions").toggle();
               
    });

    $( "#logout" ).click(function() {
         $.post(
        'accounts/logout.php',
        {
            
        },
        function(data) {
            location.href='index.php?redirect=home';
        }).fail(function(error) {
                return false;
        }); 
               
    });

    $( "#createEventbutton" ).click(function() {
        //aparece/desaparece o menu de criação de evento
         $("#createEvent").toggle();
               
    });



    $( ".deleteEvent" ).click(function(e) {
        var name = ($(".Ftitle").text());
        
         $.post(
        'events/deleteEvent.php',
        {
            'name' : name
        },
        function(data) {
            switch(data) {
                case 'failed_to_delete_event':
                    alert("failed to delete the event!");
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

    $( ".FstopF" ).click(function(e) {
        var name = ($(".Ftitle").text());

        $.post(
        'events/notGoing.php',
        {
            'name' : name
        },
        function(data) {
            switch(data) {
                case 'fail':
                    location.reload();
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

    $( ".FgoingF" ).click(function(e) {
        var name = ($(".Ftitle").text());

        $.post(
        'events/going.php',
        {
            'name' : name
        },
        function(data) {
            switch(data) {
                case 'fail':
                    location.reload();
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


})

    
