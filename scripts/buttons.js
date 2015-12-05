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
                $( ".editEvent").show();
                $( ".deleteEvent").text( host);
                $( ".deleteEvent").show();
                $( ".hostName").hide();
            }
            else{
                $( ".hostName").text(host);
                $( ".hostName").show();
                $( ".deleteEvent").hide();
                $( ".editEvent").hide();
            }

            //se for mostra o going a preto e o not going aberto, se não for o oposto
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
            //apenas mostra os comentarios se o utilizador for ao evento
            if (go){
                 $("#Fcomments").show();
                for(var j = 0; j < maxCom; j++){
                    $("#Fcomments").append('<div class="FcomUser">' + ComentaryArray[2*j] + '</div>');
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

        var sure = confirm("Are you sure you want to delete this event?");
        if(!sure)
            return false;
        
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


    $( ".editEvent").click(function(){

        var eventID;
        var name = $( ".Ftitle").text();

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
                    var host = data['host'];

                    if (host != "Delete Event"){
                        return false;
                    }

                    var date = data['dateBegin'];
                    var local = data['location'];
                    var description = data['description'];
                    var image = data['image'];
                    var tableCom = data['tableCom'];
                    var maxCom = data['maxCom'];
                    var timeH = data['time'];
                    var type = data['type'];


                    $( "#editEvent input[name=tituloAntigo]").val(name);
                    $( "#editEvent input[name=titulo]").val(name);
                    $( "#editEvent input[name=dateBegin]").val(date);
                    $( "#editEvent input[name=time]").val(timeH);
                    $( "#editEvent input[name=type]").val(type);
                    $( "#editEvent input[name=location]").val(local);
                    $( "#editEvent input[name=description]").val(description);
                    $( "#editEvent input[name=image]").val(image);

                    $( "#editEvent").toggle();

                }).fail(function(error) {
                        return false;
                }); 
            }   
        }).fail(function(error) {
                        return false;
        });   

    });

    $( "#closeEdit").click(function(){
        $("#editEvent").hide();

    });
})

    
