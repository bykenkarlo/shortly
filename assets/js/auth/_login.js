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
	$("#account_recovery_modal").modal('toggle');
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
$("#recover_acct_form").on('submit', function(e) {
	e.preventDefault();
	$("#recovery_btn").attr('disabled','disabled').text('Please wait...');
	$.ajax({
		url: base_url+'api/v1/account/_recovery',
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
			$("#recovery_btn").text(res.data.message);
			Swal.fire({
				icon: 'success',
				title: 'Success!',
			   text: res.data.message,
		  	})
			$("#account_recovery_modal").modal('hide');
			$("#recovery_btn").removeAttr('disabled', 'disabled').text('Send Recovery Email');
		}
		else{
			_csrfNonce();
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	text: res.data.message,
			})
			$("#recovery_btn").removeAttr('disabled', 'disabled').text('Send Recovery Email');
		}
	})
	.fail(function() {
		Swal.fire({
			icon: 'error',
			title: 'Error!',
		   text: "Something went wrong! Try again!",
	  	})
		console.log("error");
		$("#recovery_btn").removeAttr('disabled', 'disabled').text('Send Recovery Email');
		_csrfNonce();
	})
})