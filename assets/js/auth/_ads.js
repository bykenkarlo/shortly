if (_state == 'ads'){
    adsList(1, '', 10)
}
$("#add_new").on('click', function(){
    $("#new_ad_modal").modal('show');
})
$("#_search_ad").on('submit', function(e){
	e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
	search = $("#_search").val();
	row_num = 10;
    adsList(page_no, search, row_num);
})
$('#ads_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
	search = $("#_search").val();
	row_num = 10;
    adsList(page_no, search, row_num);
});
$("#type").on('change', function(){
    type = $("#type").val();
    if(type == 'button'){
        $("#button_color_wrapper").removeAttr('hidden','hidden');
        $("#button_text_wrapper").removeAttr('hidden','hidden');
        $("#logo_wrapper").removeAttr('hidden','hidden');
        $("#banner_wrapper").attr('hidden','hidden');
    }
    else if(type == 'banner'){
        $("#button_color_wrapper").attr('hidden','hidden');
        $("#button_text_wrapper").attr('hidden','hidden');
        $("#logo_wrapper").attr('hidden','hidden');
        $("#banner_wrapper").removeAttr('hidden','hidden');
    }
    else if(type == 'url'){
        $("#button_color_wrapper").attr('hidden','hidden');
        $("#button_text_wrapper").attr('hidden','hidden');
        $("#logo_wrapper").attr('hidden','hidden');
        $("#banner_wrapper").attr('hidden','hidden');
    }

})
$('#new_ad_form').on('submit', function(e){
	e.preventDefault();
	type = $("#type").val();
	if (type == '' || !type || type == null || type.length <= 0) {
		Swal.fire({
            icon: 'warning',
            title: 'Alert!',
            text: "Type is required!",
        })
		return false;
	}
	$("#new_ad").attr('disabled','disabled').text('Saving...');
	let formData = new FormData(this);
	$.ajax({
		url: base_url+'api/v1/ad/_new',
		type: 'POST',
        data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			Swal.fire({
			  	icon: 'success',
			  	title: 'Success!',
			 	text: res.data.message,
			})
            adsList(1,'', 10)
            $("#new_ad_modal").modal('hide');
		}
		else{
		}
		$("#new_ad").removeAttr('disabled','disabled').text('Save');

	})
})
function refreshAdsList(){
	$("#_search").val('');
	adsList(1,'', 10);
}
function adsList(page_no, search, row_num){
	$("#ads_tbl").html("<tr class='text-center'><td colspan='8'>Loading Advertisements...</td></tr>");
	let params = new URLSearchParams({'page_no':page_no, 'search':search, 'row_num':row_num});
	fetch(base_url+'api/v1/ad/_get_list?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayDataList(page_no, res.data.result, res.data.pagination, res.data.count, row_num);
	})
	.catch((error) => {
		$("#ads_tbl").html("<tr class='text-center'><td colspan='8'>Error occurs! Refresh the page and try again!</td></tr>");
		console.error('Error:', error);
		row_num = $("#row_num").val();
	});
}
function _displayDataList(page_no, result, pagination, count, row_num){
	string ='';
	url_status = '';
	url_status_text = '';
	stat_btn_bg = "";
	url_status = "";
	func = "";
	$('#ads_pagination').html(pagination);
	$('#ads_count').text('Total count: '+count);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){

            if (result[i].status == 'active') {
				stat_btn_bg = "success";
				url_status = "active"
				to_change_stat = "disabled";
			}
			
			else if (result[i].status == 'disabled') {
				stat_btn_bg = "warning";
				url_status = "disabled";
				to_change_stat = "active";
			}
			string +='<tr>'
				+'<td>'
                    +'<div class="form-check ">'
                        +'<input type="checkbox" name="url_checkbox[]" class="form-check-input url-checkbox cursor-pointer " id="'+result[i].ad_id+'" >'
                        +'<label class="form-check-label" for="_url_check_box">&nbsp;</label>'
                    +'</div>'
                +'</td>'
				+'<td><a target="_blank" href="'+base_url+'partner/'+result[i].ad_id+'">'+result[i].name+'</a></td>'
				+'<td>'+result[i].redirect_url+'</td>'
				+'<td>'+result[i].type+'</td>'
				+'<td>'+result[i].clicks+'</td>'
				+'<td>'
					+'<div class="dropdown font-10"">'
					    +'<button class="btn btn-'+stat_btn_bg+' rounded btn-xs dropdown-toggle c-white text-capitalize" type="button" id="_url_stat_dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					        +url_status
					    +'</button>'
					    +'<div class="dropdown-menu" aria-labelledby="_url_stat_dropdown">'
						    +'<span class="dropdown-item cursor-pointer text-capitalize" onclick="changeStats(\''+result[i].ad_id+'\',\''+to_change_stat+'\',\''+page_no+'\')">'+to_change_stat+'</span>'
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
						    +'<span class="dropdown-item cursor-pointer" onclick="deleteAd(\''+result[i].ad_id+'\',\''+page_no+'\')" >Delete</span>'
						+'</div>'
					+'</div>'
                +'</td>'
			+'</tr>'
		}
		$('#ads_tbl').html(string);
	}
	else{
		$("#ads_tbl").html("<tr class='text-center'><td colspan='8'>No Advertisement!</td></tr>");
	}
}
function changeStats(ad_id, status, page_no){
    csrf_token = $("#_global_csrf").val();
	$.ajax({
		url: base_url+'api/v1/ad/_change_status',
		type: 'POST',
		data: {'status':status,'csrf_token':csrf_token,'ad_id':ad_id},
	    statusCode: {
		403: () => {
			    _error403();
			}
		}
	})
	.done( (res) => {
		if (res.data.status == 'success') {
			search = $("#_search").val();
			row_num = 10;
            adsList(page_no, search, row_num)
		}
		else{
			Swal.fire({icon: 'error',title: 'Error!',html: res.data.message,
			});
		}
		_csrfNonce();
	})
    .fail(() => {
        Swal.fire({icon: 'error',title: 'Error!',html: "Something went wrong! Please refresh the page and Try again!",
      });
    })
	_csrfNonce();
}
function deleteAd(ad_id, page_no){
	csrf_token = $("#_global_csrf").val();
	Swal.fire({
		title: 'Delete?',
	 	icon: 'warning',
	 	text: 'Are you sure to delete this Ad?',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
	  	if (result.isConfirmed) {
	  		$.ajax({
				url: base_url+'api/v1/ad/_delete',
				type: 'POST',
				dataType: 'JSON',
				data: {'ad_id':ad_id,'csrf_token':csrf_token},
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
				search = $("#_search").val();
                row_num = 10;
                adsList(page_no, search, row_num);
				_csrfNonce();
			})
	  	} 
	})
}