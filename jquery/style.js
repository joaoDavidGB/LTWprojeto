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
            
            $( ".Ftitle" ).text( name);
            $( ".Fdate" ).text( date);
            $( ".Flocation" ).text( location);
            $( ".Fdescription" ).text( description);
            //$( ".FeventImage" ).text("<img src=" + image + " alt=" + "eventImage"+" />");
            $( ".FeventImage" ).html( "<img src=" + image + " alt=" + "eventImage"+" />");
        }).fail(function(error) {
                return false;
        });          
});







})

