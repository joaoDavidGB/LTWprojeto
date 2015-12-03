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
            var location = data['location'];
            var description = data['description'];
            var image = data['image'];
            var host = data['host'];
            
            $( ".Ftitle" ).text( name);
            $( ".Fdate" ).text( date);
            $( ".Flocation" ).text( location);
            $( ".Fdescription" ).text( description);
            //$( ".FeventImage" ).text("<img src=" + image + " alt=" + "eventImage"+" />");
            $( ".FeventImage" ).html( "<img src=" + image + " alt=" + "eventImage"+" />");
            
            $( ".Fhost").text(host);
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

})

    
