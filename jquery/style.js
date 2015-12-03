$("document").ready(function(){
	$( ".listEvents" ).click(function(e) {
		
		var eventID = e.currentTarget.id;
  		$.post(
        'events/getEventInfo.php',
        {
            'id' : eventID
        },
        function(data) {
            data=JSON.parse(data);
            var name = data['name'];
            var date = data['dateBegin'];
            var local = data['location'];
            var description = data['description'];
            var image = data['image'];
            var host = data['host'];
            var tableCom = data['tableCom'];
            var maxCom = data['maxCom'];

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
            
            //alteração de informação genérica
            $( ".Ftitle" ).text( name);
            $( ".Fdate" ).text( date);
            $( ".Flocation" ).text( local);
            $( ".Fdescription" ).text( description);
            $( ".FeventImage" ).html( "<img src=" + image + " alt=" + "eventImage"+" />");
            
            //codigo para alteração de comentarios a apresentar
            //array com informação relativa aos comentarios
            var ComentaryArray = data['ArrayCom'];
            //se não houver comentários, dá replace com divs vazios
            if (maxCom == 0){
                $(".FcomUser").replaceWith('<div class="FcomUser"></div>');
                $(".FcomBody").replaceWith('<div class="FcomBody"></div>');
            }
            for(var j = 0; j < maxCom; j++){
                //na primeira iteração dá replace em todos os comments com o primeiro
                if(j==0){
                    $(".FcomUser").replaceWith('<div class="FcomUser">' + ComentaryArray[0] + '</div>');
                    $(".FcomBody").replaceWith('<div class="FcomBody">' + ComentaryArray[1] + '</div>');
                } 
                else{
                    $("#Fcomments").append('<div class="FcomUser">' + ComentaryArray[2*j] + '</div>');
                    $("#Fcomments").append('<div class="FcomBody">' + ComentaryArray[2*j+1] + '</div>');
                }
            }

        }).fail(function(error) {
                return false;
        });          
});

$( "#user" ).click(function() {
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
         $("#createEvent").toggle();
               
});

$("#createEventForm").submit(function(ev){
                ev.preventDefault();

                var success = false;
                var name = document.forms["createEventForm"]["name"].value;
                var date = document.forms["createEventForm"]["dateBegin"].value;
                var location2 = document.forms["createEventForm"]["location"].value;
                var description = document.forms["createEventForm"]["description"].value;
                var image = document.forms["createEventForm"]["image"].value;

                if (name == "" || date == "" || location == "" || description == "" || image == "") {
                    alert("Fill every field before submiting.");
                    return false;
                };


                $.post(
                    'events/createEvent.php',
                    {
                    'name' : name,
                    'date' : date,
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

$("#addComment").submit(function(ev){
                ev.preventDefault();

                var eventName = ($(".Ftitle").text());
                var comment = document.forms["addComment"]["comment"].value;

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
                                alert("success!!!!");
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

    
