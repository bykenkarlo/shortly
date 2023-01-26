if (_state == 'article') {
    new_url = location.href
	_articleData(new_url);
	console.log(new_url)
}

if (_state == 'draft') {
	if (location.host == 'localhost' ) {
		new_url = location.pathname.substring(14)
		_articleData(new_url);
	}
	else{
		new_url = location.pathname.substring(7)
		_articleData(new_url);
	}
	console.log(new_url)
}

function _articleData(url){
	let params = new URLSearchParams({'url':url});
	fetch(base_url+'api/v1/article/_get_data?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		$("#article_body").html(res.data.result)
		$("#_recent_posts").html(res.data.recent_posts)
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}