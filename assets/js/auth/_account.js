if (_state == 'url_list'){
    _getUrlList(1, '', '')
    _getBlocklistUrlList(1, '', '')
}
else if(_state == 'users_list'){
    _getUsersList(1, '', '')
}
$("#_search_url_form").on('submit', function(e){
	e.preventDefault();
	keyword = $("#_search").val();
	page_no = 1;
	_getUrlList(page_no, keyword, '');
})

function _getUrlList(page_no, search, opt_status){
	$("#_url_tbl").html("<tr class='text-center'><td colspan='7'>Loading data...</td></tr>");
	let params = new URLSearchParams({'page_no':page_no, 'search':search});
	fetch(base_url+'api/v1/account/_url_list?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayDataList(page_no, res.data.result, res.data.pagination, res.data.count);
	})
	.catch((error) => {
		$("#_loan_tbl").html("<tr class='text-center'><td colspan='8'>No record found!</td></tr>");
		console.error('Error:', error);
	});
}
function _displayDataList(page_no, result, pagination, count){
	string ='';
	url_status = '';
	url_status_text = '';
	stat_btn_bg = "";
	blocklisted = "";
	url_status = "";
	to_change_stat = "";
	func = "";
	$('#_url_pagination').html(pagination);
	$('#_url_count').text('Total count: '+count);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){

			if(result[i].blocklisted == 'yes'){
				stat_btn_bg = "danger";
				url_status = "Blocklisted";
				to_change_stat = 'unblock'
				func = "UnblockURL";
				first_param = result[i].long_url;
			}
			else if (result[i].status == 'active') {
				stat_btn_bg = "success";
				url_status = "Active"
				to_change_stat = "disabled";
				func = "changeStats";
				first_param = result[i].url_param;
			}
			
			else if (result[i].status == 'disabled') {
				stat_btn_bg = "warning";
				url_status = "disabled";
				to_change_stat = "active";
				func = "changeStats";
				first_param = result[i].url_param;
			}
			
			string +='<tr>'
				+'<td>'
                    +'<div class="form-check ">'
                        +'<input type="checkbox" name="loan_checkbox[]" class="form-check-input loan-checkbox cursor-pointer " id="'+result[i].id+'" >'
                        +'<label class="form-check-label" for="_tx_check_box">&nbsp;</label>'
                    +'</div>'
                +'</td>'
				+'<td><a target="_blank" href="'+result[i].short_url_stat+'">'+result[i].url_param+'</a></td>'
				+'<td>'+result[i].long_url+'</td>'
				+'<td>'+result[i].click_count+'</td>'
				+'<td>'
					+'<div class="dropdown font-10"">'
					    +'<button class="btn btn-'+stat_btn_bg+' rounded btn-xs dropdown-toggle c-white text-capitalize" type="button" id="_url_stat_dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					        +url_status
					    +'</button>'
					    +'<div class="dropdown-menu" aria-labelledby="_url_stat_dropdown">'
						    +'<span class="dropdown-item cursor-pointer text-capitalize" onclick="'+func+'(\''+first_param+'\',\''+to_change_stat+'\',\''+page_no+'\')">'+to_change_stat+'</span>'
						+'</div>'
					+'</div>'
				+'</td>'
				+'<td>'+result[i].created_at+'</td>'
				+'<td>'
                    +'<div class="dropdown font-10"">'
					    +'<button class="btn btn-light btn-sm dropdown-toggle font-12 rounded" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					        +'Action'
					    +'</button>'
					    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
						    +'<a class="dropdown-item" href="'+base_url+'" target="_blank" rel="noopener">View More</a>'
						    +'<span class="dropdown-item cursor-pointer" href="#edit_loan_details"  rel="noopener" >Edit details</span>'
						    +'<span class="dropdown-item cursor-pointer" onclick="blocklistURL(\''+result[i].long_url+'\',\''+page_no+'\', \''+''+'\')" >Blocklist</span>'
						    +'<span class="dropdown-item cursor-pointer" onclick="deleteURL(\''+result[i].url_param+'\',\''+page_no+'\')" >Delete</span>'
						+'</div>'
					+'</div>'
                +'</td>'
			+'</tr>'
		}
		$('#_url_tbl').html(string);
	}
	else{
		$("#_url_tbl").html("<tr class='text-center'><td colspan='7'>No records found!</td></tr>");
	}
}
$('#_url_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
	opt_status = $('#_select_status').val();
	search = $("#_search").val();
    _getUrlList(page_no, search, opt_status);
});


const changeStats = (url_param,status, page_no) => {
	csrf_token = $("#_global_csrf").val();
	$.ajax({
		url: base_url+'api/v1/shortener/_change_status',
		type: 'POST',
		data: {'status':status,'csrf_token':csrf_token,'url_param':url_param},
	    statusCode: {
		403: () => {
			    _error403();
			}
		}
	})
	.done( (res) => {
		if (res.data.status == 'success') {
			search = $("#_search").val();
            _getUrlList(page_no, search, '')
		}
		else{
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	html: res.data.message,
			});
	        $("#_shorten_url_btn").text('Shorten URL').removeAttr('disabled', 'disabled');
		}
		_csrfNonce();
	})
    .fail(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: "Something went wrong! Please refresh the page and Try again!",
      });
    })
	_csrfNonce();
}
$("#_search_user_form").on('submit', function(e){
	e.preventDefault();
	keyword = $("#_search").val();
	page_no = 1;
	_getUsersList(page_no, keyword, '');
})
$('#_user_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    _getUsersList(page_no, '', '');
});

function _getUsersList(page_no, search, opt_status){
	$("#_user_tbl").html("<tr class='text-center'><td colspan='7'>Loading data...</td></tr>");
	let params = new URLSearchParams({'page_no':page_no, 'search':search});
	fetch(base_url+'api/v1/account/_users_list?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayUserDataList(page_no, res.data.result, res.data.pagination, res.data.count);
	})
	.catch((error) => {
		$("#_user_tbl").html("<tr class='text-center'><td colspan='7'>No record found!</td></tr>");
		console.error('Error:', error);
	});
}
function _displayUserDataList(page_no, result, pagination, count){
	string ='';
	verified = ''; 
	user_type = "";
	$('#_user_pagination').html(pagination);
	$('#_user_count').text('Total count: '+count);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){
			if (result[i].user_type == 'admin') {
                user_type = '<span class="cursor-pointer badge font-12 text-capitalize bg-success c-white">Admin</span>';
			}
			else if (result[i].user_type == 'user') {
                user_type = '<span class="cursor-pointer badge font-12 bg-primary c-white text-capitalize">User</span>';
			}

			if (result[i].email_verified == 'yes') {
                verified = '<span class="cursor-pointer badge font-12 text-capitalize bg-success c-white">Yes</span>';
			}
			else if (result[i].email_verified == 'no') {
                verified = '<span class="cursor-pointer badge font-12 text-capitalize bg-warning c-white">No</span>';
			}
			else if (result[i].email_verified == 'pending') {
                verified = '<span class="cursor-pointer badge font-12 text-capitalize bg-info c-white">Pending</span>';
			}
			
			string +='<tr>'
				+'<td>'
                    +'<div class="form-check ">'
                        +'<input type="checkbox" name="loan_checkbox[]" class="form-check-input loan-checkbox cursor-pointer " id="'+result[i].id+'" >'
                        +'<label class="form-check-label" for="_tx_check_box">&nbsp;</label>'
                    +'</div>'
                +'</td>'
				+'<td>'+result[i].username+'</td>'
				+'<td>'+user_type+'</td>'
				+'<td>'+result[i].email_address+'</td>'
				+'<td>'+verified+'</td>'
				
				+'<td>'+result[i].created_at+'</td>'
				+'<td>'
                    +'<div class="dropdown font-10"">'
					    +'<button class="btn btn-light btn-sm dropdown-toggle font-12 rounded" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					        +'Action'
					    +'</button>'
					    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
						    +'<a class="dropdown-item" href="'+base_url+'logged/user/'+result[i].username+'" target="_blank" rel="noopener">Login</a>'
						    +'<span class="dropdown-item cursor-pointer" href="#edit_loan_details"  rel="noopener" >Edit details</span>'
						+'</div>'
					+'</div>'
                +'</td>'
			+'</tr>'
		}
		$('#_user_tbl').html(string);
	}
	else{
		$("#_user_tbl").html("<tr class='text-center'><td colspan='7'>No records found!</td></tr>");
	}
}
function deleteURL(url_param,page_no){
	csrf_token = $("#_global_csrf").val();
	Swal.fire({
		title: 'Delete?',
	 	icon: 'warning',
	 	text: 'Are you sure to delete this URL?',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
	  	if (result.isConfirmed) {
	  		$.ajax({
				url: base_url+'api/v1/shortener/_delete_url',
				type: 'POST',
				dataType: 'JSON',
				data: {'url_param':url_param,'csrf_token':csrf_token},
		        statusCode: {
				403: function() {
					  	_error403();
					}
				}
			})
			.done(function(res) {
				if (res.data.status == 'success') {
					Swal.fire('Success!', res.data.message, 'success');
				}
				else{
					Swal.fire('Error!', 'Something went wrong! Please Try again!', 'error');
				}
				_getUrlList(page_no,'','');
				_csrfNonce();

			})
	  	} 
	})
}
$("#_blocklist_form").on('submit', function(e){
	e.preventDefault();
	$("#_save_blocklist_url").text('Saving...')
	url = $("#_blocklist_url").val();
	note = $("#_note").val();
	blocklistURL(url, 1, note);
})
function blocklistURL(long_url, page_no, note){
	csrf_token = $("#_global_csrf").val();
	Swal.fire({
		title: 'Blocklist URL?',
	 	icon: 'warning',
	 	text: 'Are you sure to Blocklist this URL?',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
	  	if (result.isConfirmed) {
	  		$.ajax({
				url: base_url+'api/v1/shortener/_blocklist_url',
				type: 'POST',
				dataType: 'JSON',
				data: {'url':long_url,'csrf_token':csrf_token, note:note},
		        statusCode: {
				403: function() {
					  	_error403();
					}
				}
			})
			.done(function(res) {
				if (res.data.status == 'success') {
					Swal.fire('Success!', res.data.message, 'success');
					_getUrlList(page_no,'','');
					_getBlocklistUrlList(page_no,'','');
					$("#_add_blocklist_modal").modal('hide');
				}
				else if (res.data.status == 'error') {
					Swal.fire('Error!', res.data.message, 'error');
				}
				else{
					Swal.fire('Error!', 'Something went wrong! Please Try again!', 'error');
				}
				_csrfNonce();
				$("#_save_blocklist_url").text('Save')
			})
	  	} 
	})
}
function UnblockURL(long_url,page_no){
	csrf_token = $("#_global_csrf").val();
	Swal.fire({
		title: 'Unblocklist URL?',
	 	icon: 'warning',
	 	text: 'Are you sure to Unblocklist this URL?',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
	  	if (result.isConfirmed) {
	  		$.ajax({
				url: base_url+'api/v1/shortener/_unblocklist_url',
				type: 'POST',
				dataType: 'JSON',
				data: {'url':long_url,'csrf_token':csrf_token},
		        statusCode: {
				403: function() {
					  	_error403();
					}
				}
			})
			.done(function(res) {
				if (res.data.status == 'success') {
					Swal.fire('Success!', res.data.message, 'success');
				}
				else{
					Swal.fire('Error!', 'Something went wrong! Please Try again!', 'error');
				}
				_getUrlList(page_no,'','');
				_getBlocklistUrlList(page_no,'','');
				_csrfNonce();

			})
	  	} 
	})
}

function checkLink(){
	var api_key =  "AIzaSyCm_T4r1vS1qL-db7RKqjc22xg9OaYo-a8"; //My actual key is in here
	var googleURL = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key="+api_key;
	googleURL = googleURL + apiKey;
	console.log(googleURL);
	var payload =
	{
		"client": {
		  "clientId":      "shortlyapp382402",
		  "clientVersion": "382402"
		},
		"threatInfo": {
		  "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING"],
		  "platformTypes":    ["WINDOWS"],
		  "threatEntryTypes": ["URL"],
		  "threatEntries": [
			{"url": "https://testsafebrowsing.appspot.com/s/malware.html"},
		  ]
		}
	};
	$.ajax({
		 url: googleURL,
		 dataType: "json",
		 type: 'POST',
		contentType: "applicaiton/json; charset=utf-8",
		 data: JSON.stringify(payload),
		 statusCode: {
			 403: () => {
				 _error403();
			 }
		 }
	 })
	 .done( (res) => {
		 console.log(res)
		 if(res.matches[0].threatType == 'MALWARE'){
			return 'malware';
		 }
	 })
  }
$("#add_blocklist_url").on('click', function(){
	$("#_add_blocklist_modal").modal('toggle');
})
$("#_search_bk_url_form").on('submit', function(e){
	e.preventDefault();
	keyword = $("#_search_bk").val();
	page_no = 1;
	_getBlocklistUrlList(page_no, keyword, '');
})
function _getBlocklistUrlList(page_no, search, opt_status){
	$("#_blocklist_url_tbl").html("<tr class='text-center'><td colspan='5'>Loading data...</td></tr>");
	let params = new URLSearchParams({'page_no':page_no, 'search':search});
	fetch(base_url+'api/v1/account/_blocklist_url_list?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayBlocklistURLDataList(page_no, res.data.result, res.data.pagination, res.data.count);
	})
	.catch((error) => {
		$("#_blocklist_url_tbl").html("<tr class='text-center'><td colspan='5'>No record found!</td></tr>");
		console.error('Error:', error);
	});
}
function _displayBlocklistURLDataList(page_no, result, pagination, count){
	string ='';
	$('#_blocklist_url_pagination').html(pagination);
	$('#_blocklist_url_count').text('Total count: '+count);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){
			string +='<tr>'
				+'<td>'
                    +'<div class="form-check ">'
                        +'<input type="checkbox" name="loan_checkbox[]" class="form-check-input loan-checkbox cursor-pointer " id="'+result[i].id+'" >'
                        +'<label class="form-check-label" for="_tx_check_box">&nbsp;</label>'
                    +'</div>'
                +'</td>'
				+'<td><a target="_blank" href="'+result[i].url+'">'+result[i].url+'</a></td>'
				+'<td>'+result[i].note+'</td>'
				+'<td>'+result[i].created_at+'</td>'
				+'<td>'
                    +'<div class="dropdown font-10"">'
					    +'<button class="btn btn-light btn-sm dropdown-toggle font-12 rounded" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					        +'Action'
					    +'</button>'
					    +'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
						    +'<span class="dropdown-item cursor-pointer text-capitalize" onclick="UnblockURL(\''+result[i].url+'\',\'active\',\''+page_no+'\')">Unblock</span>'
						+'</div>'
					+'</div>'
                +'</td>'
			+'</tr>'
		}
		$('#_blocklist_url_tbl').html(string);
	}
	else{
		$("#_blocklist_url_tbl").html("<tr class='text-center'><td colspan='5'>No records found!</td></tr>");
	}
}
$('#_blocklist_url_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    _getBlocklistUrlList(page_no, '', '');
});
