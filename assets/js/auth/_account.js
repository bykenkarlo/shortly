if (_state == 'url_list'){
    _getUrlList(1, '', 10, '')
    _getBlocklistUrlList(1, '', '')
}
else if(_state == 'users_list'){
    _getUsersList(1, '', '')
}
else if(_state == 'activity_logs'){
    _getActivityLogs(1, '', '')
}
$("#_search_activity").on('submit', function(e){
	e.preventDefault();
	keyword = $("#_search").val();
	page_no = 1;
	_getActivityLogs(page_no, keyword, '');
})
$('#activity_logs_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
	opt_status = $('#_select_status').val();
	search = $("#_search").val();
	row_num = $("#row_num").val();
    _getActivityLogs(page_no, search, row_num, opt_status);
});
$("#row_num").on('change', function(){
	page_no = 1;
	keyword = ($("#_search").val() !== '' || !$("#_search").val()) ? $("#_search").val() : "";
	row_num = $(this).val();
	_getUrlList(page_no, keyword, row_num, '');
});
$("#_search_url_form").on('submit', function(e){
	e.preventDefault();
	page_no = 1;
	keyword = ($("#_search").val() !== '' || !$("#_search").val()) ? $("#_search").val() : "";
	row_num = $("#row_num").val();
	_getUrlList(page_no, keyword, row_num, '');
})
function refreshURLList(){
	$("#_search").val('');
	_getUrlList(1,'', 10, '');
}
function _getUrlList(page_no, search, row_num, opt_status){
	$("#_url_tbl").html("<tr class='text-center'><td colspan='8'>Loading data...</td></tr>");
	let params = new URLSearchParams({'page_no':page_no, 'search':search, 'row_num':row_num});
	fetch(base_url+'api/v1/account/_url_list?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayDataList(page_no, res.data.result, res.data.pagination, res.data.count, row_num);
		$("#disable_multiple_url_btn").attr("data-row-count", page_no);
	})
	.catch((error) => {
		$("#_url_tbl").html("<tr class='text-center'><td colspan='8'>Error occurs! Refresh the page and try again!</td></tr>");
		console.error('Error:', error);
		row_num = $("#row_num").val();
	});
}
function _displayDataList(page_no, result, pagination, count, row_num){
	string ='';
	url_status = '';
	url_status_text = '';
	stat_btn_bg = "";
	blocklisted = "";
	url_status = "";
	username = "";
	to_change_stat = "";
	user_link = "";
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
			username = result[i].username;
			user_link = '<a href="'+base_url+'logged/user/'+result[i].username+'" target="_blank" rel="noopener">'+result[i].username+'</a>';
			if(username == 'N/A'){
				user_link = "N/A";
			}
			string +='<tr>'
				+'<td>'
                    +'<div class="form-check ">'
                        +'<input data-url_param_'+result[i].id+'="'+result[i].url_param+'" type="checkbox" name="url_checkbox[]" class="form-check-input url-checkbox cursor-pointer " id="'+result[i].id+'" >'
                        +'<label class="form-check-label" for="_url_check_box">&nbsp;</label>'
                    +'</div>'
                +'</td>'
				+'<td><a target="_blank" href="'+base_url+'stat/'+result[i].url_param+'">'+result[i].url_param+'</a></td>'
				+'<td>'+result[i].long_url+'</td>'
				+'<td>'+user_link+'</td>'
				+'<td>'+result[i].click_count+'</td>'
				+'<td>'
					+'<div class="dropdown font-10"">'
					    +'<button class="btn btn-'+stat_btn_bg+' rounded btn-xs dropdown-toggle c-white text-capitalize statid-'+result[i].id+'" type="button" id="_url_stat_dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					        +url_status
					    +'</button>'
					    +'<div class="dropdown-menu" aria-labelledby="_url_stat_dropdown">'
						    +'<span class="dropdown-item cursor-pointer text-capitalize spanid-'+result[i].id+'"  onclick="'+func+'(\''+first_param+'\',\''+to_change_stat+'\',\''+page_no+'\',\''+result[i].id+'\',\''+stat_btn_bg+'\')">'+to_change_stat+'</span>'
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
						    +'<span class="dropdown-item cursor-pointer" onclick="blocklistURLModal(\''+result[i].long_url+'\',\''+page_no+'\', \''+''+'\')" >Blocklist</span>'
						    +'<span class="dropdown-item cursor-pointer" onclick="deleteURL(\''+result[i].url_param+'\',\''+page_no+'\')" >Delete</span>'
						+'</div>'
					+'</div>'
                +'</td>'
			+'</tr>'
		}
		$('#_url_tbl').html(string);
	}
	else{
		$("#_url_tbl").html("<tr class='text-center'><td colspan='8'>Error occurs! Refresh the page and try again!</td></tr>");
	}
}
$('#_url_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
	opt_status = $('#_select_status').val();
	search = $("#_search").val();
	row_num = $("#row_num").val();
    _getUrlList(page_no, search, row_num, opt_status);
});


const changeStats = (url_param, status, page_no, id, stat_btn_bg) => {
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
			row_num = $("#row_num").val()
			;
			new_stat_btn_bg = 'warning';
			if(stat_btn_bg == 'warning'){
				new_stat_btn_bg = 'success';
			}

			
			$(".statid-"+id).text(status).removeClass("btn-"+stat_btn_bg).addClass("btn-" + new_stat_btn_bg);
			
			new_status = "active";
			if (status == 'disabled'){
				new_status = "active";
			}
			$(".spanid-"+id).removeAttr('changeStats').attr('changeStats', url_param +", "+ new_status+", "+page_no+"," +id+","+new_stat_btn_bg);


            // _getUrlList(page_no, search, row_num, '');
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
$("#_search_activity").on('submit', function(e){
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
						    +'<a class="dropdown-item" href="'+base_url+'logged/user/'+result[i].username+'" target="_blank" rel="noopener">Admin Login</a>'
						    +'<a class="dropdown-item" href="'+result[i].universal_login+'" target="_blank" rel="noopener">Universal Login</a>'
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
				row_num = $("#row_num").val();
				_getUrlList(page_no,'', row_num, '');
				_csrfNonce();

			})
	  	} 
	})
}
$("#_blocklist_form").on('submit', function(e){
	e.preventDefault();
	url = $("#_blocklist_url").val();
	note = $("#_note").val();
	blocklistURL(url, 1, note);
})
function blocklistURLModal(long_url, page_no, note){
	$("#_add_blocklist_modal").modal('toggle');
	$("#_blocklist_url").val(long_url);
}
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
			$("#_save_blocklist_url").text('Saving...').attr('disabled','disabled');
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
					// _getUrlList(page_no,'','');
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
				$("#_save_blocklist_url").text('Save').removeAttr('disabled','disabled')
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
				// _getUrlList(page_no,'','');
				_getBlocklistUrlList(page_no,'','');
				_csrfNonce();

			})
	  	} 
	})
}

function checkLink(){
	var api_key =  "AIzaSyDck2wgJU_lerRlt8WHCOo8aQnb01AKpYo"; //My actual key is in here
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
$("#url_checklist").on('change', function() {
	$('.url-checkbox').prop("checked", true);
	if( !$(this).is(':checked') ){
		$('.url-checkbox').prop("checked", false);
		$("#disable_multiple_url_btn").removeAttr('hidden','hidden');
	}
	$("#disable_multiple_url_btn").removeAttr('hidden','hidden');
})
$("#disable_multiple_url_btn").on('click', function (){
	page_no = $("#disable_multiple_url_btn").attr('data-row-count');
	if( !$('input[name="url_checkbox[]"]').is(':checked')  ){
		Swal.fire({
			icon: 'warning',
			title: 'Error!',
			text: 'Select URLs to Disable!',
		});
		return false;
	}
	Swal.fire({
		title: 'Disable Multiple Record?',
	 	icon: 'warning',
	 	text: 'Are you sure to disable this records?',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
	  	if (result.isConfirmed) {
	  		url_checkbox_arr = [];
	  		$('input[name="url_checkbox[]"]').each(function() {
		      if (jQuery(this).is(":checked")) {
		        var id = this.id;
		        url_checkbox_arr.push(id);
		      }
		    });

			$("#disable_multiple_url_btn").attr('disabled','disabled').text('Processing....');
	  		$.ajax({
				url: base_url+'api/v1/shortener/_disable_multiple_url',
				type: 'POST',
				dataType: 'JSON',
				data: {url_checkbox:url_checkbox_arr},
				statusCode: {
				403: function() {
					  	_error403();
					}
				}
			})
			.done(function(res) {
				if (res.data.status == 'success') {
					$('.url-checkbox').prop("checked", false)
					$("#url_checklist").prop("checked", false)
					Swal.fire({
					  	icon: 'success',
					  	title: 'Success!',
					 	text: res.data.message,
					})
					keyword = ($("#_search").val() !== '' || !$("#_search").val()) ? $("#_search").val() : "";
					row_num = $("#row_num").val();

					for(var i = 0; i < url_checkbox_arr.length; i++){
						console.log(url_checkbox_arr[i])
						$(".statid-"+url_checkbox_arr[i]).removeClass('btn-success').addClass('btn-warning').text('Disabled');
						url_param = $("#"+url_checkbox_arr[i]).attr('data-url_param_'+url_checkbox_arr[i]);
						$(".spanid-"+url_checkbox_arr[i]).attr('onclick','changeStats(\''+url_param+'\',\'active\',1 , \''+url_checkbox_arr[i]+'\'\'warning\')');
					}
				}
				else{
					Swal.fire({
					  	icon: 'error',
					  	title: 'Error!',
					 	text: res.data.message,
					})
					_csrfNonce();
				}
				$("#disable_multiple_url_btn").removeAttr('disabled','disabled').text('Disable URLs');

			})
			.fail(function() {
				console.log("error");
				$("#disable_multiple_url_btn").removeAttr('disabled').text('Disable URLs');
				_csrfNonce();
			})
	  	} 
	})
})

function _getActivityLogs(page_no, search, opt_status){
	$("#activity_logs").html("<tr class='text-center'><td colspan='7'>Loading data...</td></tr>");
	let params = new URLSearchParams({'page_no':page_no, 'search':search});
	fetch(base_url+'api/v1/account/_activity_logs?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayActivityLogsData(page_no, res.data.result, res.data.pagination, res.data.count);
	})
	.catch((error) => {
		$("#activity_logs").html("<tr class='text-center'><td colspan='7'>No record found!</td></tr>");
		console.error('Error:', error);
	});
}
function _displayActivityLogsData(page_no, result, pagination, count){
	string ='';
	username = "";
	$('#activity_logs_pagination').html(pagination);
	$('#activity_logs_count').text('Total count: '+count);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){
			username = result[i].username
			if (result[i].username == 'sysadmin') {
                username = 'System';
			}
			string +='<tr>'
				+'<td>'
                    +'<div class="form-check ">'
                        +'<input type="checkbox" name="loan_checkbox[]" class="form-check-input loan-checkbox cursor-pointer " id="'+result[i].id+'" >'
                        +'<label class="form-check-label" for="_tx_check_box">&nbsp;</label>'
                    +'</div>'
                +'</td>'
				+'<td>'+username+'</td>'
				+'<td>'+result[i].message_log+'</td>'
				+'<td>'+result[i].ip_address+'</td>'
				+'<td>'+result[i].browser+'</td>'
				+'<td>'+result[i].platform+'</td>'
				+'<td>'+result[i].created_at+'</td>'
			+'</tr>'
		}
		$('#activity_logs').html(string);
	}
	else{
		$("#activity_logs").html("<tr class='text-center'><td colspan='7'>No records found!</td></tr>");
	}
}
$("#scan_url_btn").on('click', function() {
	$('.daterangepicker').css('z-index','1600');
	$("#scan_url_modal").modal('toggle');
})
$("#scan_btn").on('click', function() {
	$("#scan_url_btn").text('Scanning...').attr('disabled','disabled');
	from = $('#select_date').data('daterangepicker').startDate;
	to = $('#select_date').data('daterangepicker').endDate;
	let params = new URLSearchParams({'from':from, 'to':to});
	let url_api = base_url+'api/v1/scan/_google_safe_browsing_url_v2?'+params;

	fetch(url_api, {
		method: "GET",
			headers: {
			  'Accept': 'application/json',
			  'Content-Type': 'application/json'
			},
	})
	.then(response => response.json())
	.then(res => {
		$("#scan_url_modal").modal('hide');
	})
	.catch((error) => {
		console.error('Error:', error);
	});
	// window.open(url_api);
	$("#scan_url_btn").text('Scan').removeAttr('disabled','disabled');
})