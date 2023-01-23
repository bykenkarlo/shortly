function _getUrlList(page_no, search, opt_status){
	// _select_date = $('#_select_date').val();
	// from = _select_date.substring(0, 10);
	// to = _select_date.substring(_select_date.length, 13);

	$("#_url_tbl").html("<tr class='text-center'><td colspan='6'>Loading data...</td></tr>");
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
	url_ddlist = ''; // dropdown list
	stat_btn_bg = "";
	$('#_url_pagination').html(pagination);
	$('#_url_count').text('Total count: '+count);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){
			if (result[i].status == 'active') {
				stat_btn_bg = "success";
                url_ddlist = '<span class="dropdown-item cursor-pointer text-capitalize" onclick="changeStats(\''+result[i].url_param+'\',\'disabled\',\''+page_no+'\')">Disabled</span>';
			}
			else if (result[i].status == 'disabled') {
				stat_btn_bg = "danger";
                url_ddlist = '<span class="dropdown-item cursor-pointer text-capitalize" onclick="changeStats(\''+result[i].url_param+'\',\'active\',\''+page_no+'\')">Active</span>';
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
					    +'<button class="btn btn-'+stat_btn_bg+' rounded btn-xs dropdown-toggle text-capitalize" type="button" id="_url_stat_dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
					        +result[i].status
					    +'</button>'
					    +'<div class="dropdown-menu" aria-labelledby="_url_stat_dropdown">'
						    +url_ddlist
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
						+'</div>'
					+'</div>'
                +'</td>'
			+'</tr>'
		}
		$('#_url_tbl').html(string);
	}
	else{
		$("#_url_tbl").html("<tr class='text-center'><td colspan='6'>No records found!</td></tr>");
	}
}
$('#_url_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
	opt_status = $('#_select_status').val();
    _getUrlList(page_no, '', opt_status);
});

if (_state == 'url_list'){
    _getUrlList(1, '', '')
}
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
            _getUrlList(page_no, 'search', '')
		}
		else{
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	html: res.data.message,
			});
	        $("#_shorten_url_btn").text('Shorten URL').removeAttr('disabled', 'disabled');
		}
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