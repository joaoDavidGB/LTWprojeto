$("document").ready(function(){
	$( ".listEvents" ).click(function(e) {

        //obtem a informação do evento clicado
		var eventIDA = e.currentTarget.id;
        eventID= eventIDA.substring(1, 4);
        changeDisplay(eventID);
         
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

    $('#Fcomments').on('click', '.deleteC', function(ev) {
        ev.preventDefault();
        var id = this.id;
        id = id.substring(7, 9);
        $.post(
            'events/deleteComment.php',
            {
                'id' : id
            },
            function(data){
                if(data == 'fail'){
                    alert('fail');
                }
                else if (data == 'success'){
                    location.reload();
                }
                else{
                    alert(data);
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

    $( "#Fpeople").click(function(){
        $("#FlistPeople").toggle();
        $("#closeList").toggle();

    })

    $( "#closeList").click(function(){
        $("#FlistPeople").toggle();
        $("#closeList").toggle();

    })

    $("#eventsAttending").click(function(){
        $("#userEventsAttending").toggle();
    })

    $("#closeEventsAttending").click(function(){
        $("#userEventsAttending").toggle();
    })

    $("#Settings").click(function(){
        $("#UserSettings").toggle();
    })

    $("#closeUserSetting").click(function(){
        $("#UserSettings").toggle();
    })

    $("#Delete").click(function(){
        var x = confirm("Do you really want to permanently delete this account?");
        if(x){
            $("#DeleteAcc").toggle();
        }
    })

    $("#publicTab").click(function(){
        $("#invitedEvents").hide();
        $("#publicEvents").show();
        $("#publicTab").css("background-color", "orange");
        $("#publicTab").css("border", "2px outset red");
        $("#publicTab").css("color", "black");
        $("#invitedTab").css("background-color", "black");
        $("#invitedTab").css("color", "grey");
        $("#invitedTab").css("border", "2px inset grey");
    })

    $("#invitedTab").click(function(){
        $("#publicEvents").hide();
        $("#invitedEvents").show();
        $("#publicTab").css("background-color", "black");
        $("#publicTab").css("color", "grey");
        $("#publicTab").css("border", "2px inset grey");
        $("#invitedTab").css("background-color", "orange");
        $("#invitedTab").css("color", "black");
        $("#invitedTab").css("border", "2px outset red");
    })

    $( "#listEventsAttending p").click(function(ev){
        var id = ev.currentTarget.id;
        id = id.substring(6, 9);
        changeDisplay(id);
        $("#userEventsAttending").hide();
    })

    function changeDisplay(id){
        var eventID = id;
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
                    $("#eventInfo").hide();
                }
                else{
                    $("#P"+eventID).css("background-color", "green");
                    $("#I"+eventID).css("background-color", "green");
                    $("#eventInfo").show("slow");
                }

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



            $("#Fpeople").text(numberPeople + " people going.");
            $("#FlistPeople").hide();
        $("#closeList").hide();
            $("#FlistPeople").empty();
            $("#FlistPeople").append('<p id="listTitle">List of people</p>');
            for(var i = 0; i < numberPeople; i++){
                var person = people[i]['username'];
                $("#FlistPeople").append('<p>'+person+'</p>');
            }

            //alteração de informação genérica
            $( ".Ftitle" ).text( name);
            $( ".FdateTime" ).html( date+"<br>"+timeH);
            $( ".FTypeLocation").text("Location:"+local+ "  || Event Type:"+type);
            $( ".Fdescription" ).text( description);
            $( ".FeventImage" ).html( "<img src=" + image + " alt=" + "eventImage"+" />");

            if(Fprivate == 0){
                $(".FprivateEvent").text("Public");
            }
            else
                $(".FprivateEvent").text("Private");
            
            //codigo para alteração de comentarios a apresentar
            //array com informação relativa aos comentarios
            var ComentaryArray = data['ArrayCom'];
            $(".FcomUser").remove();
            $(".FcomBody").remove();
            $(".deleteC").remove();
            //apenas mostra os comentarios se o utilizador for ao evento
            if (go){
                 $("#Fcomments").show();
                for(var j = 0; j < maxCom; j+=2){
                    $("#Fcomments").append('<div class="FcomUser">' + ComentaryArray[2*j] + '</div>');
                    if(host == "Delete Event" || data['session'] == ComentaryArray[2*j]){
                         $("#Fcomments").append('<div class="deleteC" id="deleteC'+ComentaryArray[2*j+2]+'">delete</div>');
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

})

    
