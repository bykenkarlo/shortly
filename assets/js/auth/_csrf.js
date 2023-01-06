function _csrfNonce(){
	fetch(base_url+'api/v1/xss/_get_csrf_data', {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		$("input[name=csrf_token]").val(res.data.hash)
		$("#csrf_token").val(res.data.hash)
		var csrf_token = res.data.hash;
	})
	.catch((error) => {
		console.error('Error:', error);
	});

}
function _error403(){
	Swal.fire({
		icon: 'error',
		title: 'Oh Snap! CSRF Error!',
		text: 'Refresh this page and try again!',
	})
}