let installable = true;
if ("serviceWorker" in navigator) {
  window.addEventListener("load", function() {
    navigator.serviceWorker
      .register("/serviceWorker.js")
      .then(res => console.log())
      .catch(err => console.log("PWA not working", err))
    	installable = false;
  })
}
window.addEventListener("beforeinstallprompt", function(e) {
  // log the platforms provided as options in an install prompt
  console.log(e.platforms); // e.g., ["web", "android", "windows"]
  e.userChoice.then(function(choiceResult) {
    console.log(choiceResult.outcome); // either "accepted" or "dismissed"
  }, handleError);
});

const _accessPage = (page) => {
    $("#loader").removeAttr('hidden','hidden');

    if(page.indexOf('#') !== -1){
        url = page.split("#")
        location.href=base_url+'#'+url[1];
        $("html, body").animate({scrollTop:$(window.location.hash).position().top}, 500);
        $("#loader").attr('hidden','hidden');
    }
    else if(page == '') {
        location.href=base_url
    }
    else{
        location.href=base_url+''+page
    }
}

const _guest_defaults = () => {
	fetch(base_url+'api/v1/_website_guest',{
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {})
	.catch((error) => {
		console.error('Error:', error);
	});
}
_guest_defaults();