function changeSong_Internal(id) {
    //When changing song via dropdown, load the new contents of the page.
	
	if (id != 'NULL') {

        // Create request to songPageLoad php routine
        request = $.ajax({
        	//TODO absolute paths are rubbish
    	url: "resources/songPageInfoJS.php",
		//function: "songPageLoad()",
		type: "GET",
		data: {"id": id},
		cache: false
		});

		request.done(function (response) {
			//Output it.
			var currentURL = window.location.href;
			var address = currentURL.split("?");
			var newURL = address[0] + "?" + id;
			window.location.href=newURL
			$('#songPage').html(response);
		});

		request.fail(function (jqXHR, textStatus, errorThrown) {
			console.error("The following error occured: " + textStatus, errorThrown)
		});
	}
}

 function changesArtist() {
     var id = $(event.target).val();
     if (id != 'NULL') {

         //console.log(id);
         request = $.ajax({
             url: "resources/artistPageInfoJS.php",
             function: "artistPageLoad()", //doesn't do anything?
             type: "GET",
             data: {"id": id},
             cache: false
         });

         request.done(function (response) {
             console.log("New page loaded");
             var currentURL = window.location.href;
             var address = currentURL.split("?");
             var newURL = address[0] + "?" + id;
             window.location.href=newURL
             // var output = $.parseJSON( response );
             $('#artistPage').html(response);
         });

         request.fail(function (jqXHR, textStatus, errorThrown) {
             console.error("The following error occured: " + textStatus, errorThrown)
         });
     }
 }
 
 function changeSong_Dropdown() {
	 // Wrapper for when song changes from the dropdown
	 changeSong_Internal($(event.target).val());
 }
 
 function changeSong_Forced(id) {
	 // Wrapper when forcing a redirect
	console.log(id);
	 changeSong_Internal(id);
 }
