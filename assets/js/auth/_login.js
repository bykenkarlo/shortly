const _showPassword = () =>{
	$("#_password").attr('type','text');
	$("#_show_password").attr('hidden','hidden');
	$("#_hide_password").removeAttr('hidden');
}
const _hidePassword = () =>{
	$("#_password").attr('type','password');
	$("#_hide_password").attr('hidden','hidden');
	$("#_show_password").removeAttr('hidden');
}
$("#_forgot_password").on('click', function() {
	$("#_forgot_password_modal").modal('toggle');
});
$("#_login_form").on('submit', function(e) {
	e.preventDefault();
	$("#_login_btn").attr('disabled','disabled').text('Please wait...');
	$.ajax({
		url: base_url+'api/v1/account/_login',
		type: 'POST',
		dataType: 'JSON',
		data: $(this).serialize(),
		statusCode: {
		403: function() {
			  	_error403();
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$("#_login_btn").text(res.data.message);
			setTimeout(function(){window.location.href=res.data.url}, 3000)
		}
		else{
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	text: res.data.message,
			})
			_csrfNonce();
			$("#_login_btn").removeAttr('disabled').text('Log In');
		}
	})
	.fail(function() {
		console.log("error");
		$("#_login_btn").removeAttr('disabled').text('Log In');
		_csrfNonce();
	})
})