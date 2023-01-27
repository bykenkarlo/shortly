var clipboard = new ClipboardJS('.copy-url', {
	container: document.getElementById('_images_modal')
});
clipboard.on('success', function(e) {
	e.clearSelection();
    alertBox('Copied URL', 3000);
});

$("#_show_categories_btn").on('click', function() {
	_getCategoryTbl(1);
	$("#_categories_modal").modal('toggle')
});
$('#_add_category_btn').on('click', function(){
	$('#_add_category_form_div').removeAttr('hidden');
})
$('#_article_title').keyup(function(){
	article_title = $(this).val();
	_articleURL(article_title)
});
$('#_cancel_category_btn').on('click', function(){
	$('#_add_category_form_div').attr('hidden', 'hidden');
})
$('#_article_url').keyup(function(){
	url = $(this).val();
	_articleURL(url)
  	
});
if (_state == 'blog_list') {
	_showArticles(1);
}
else if (_state=='new_blog'||_state=='edit_blog'){
	_showImages(1);
}
const alertBox = (text, fade_out) => {
    $("#_custom_alert").removeAttr('hidden','hidden').text(text);
    setTimeout(() => {
        $("#_custom_alert").attr('hidden','hidden');
    }, fade_out);
}
function _articleURL(url){
	link = url.replace(/[&\/\\#,+()$~%.’"'_’':*?<>{ }`“”]/g, '-');
  	$('#_article_url').val(link);
}
function uploadArticleImageFile(){
	img_input = $("#_article_img")[0];
	// readURL(img_input)
}

$("#_category_name").keyup(function() {
	category = $(this).val();

	if (category.length > 0) {
		$(".category-wrapper .alert-tooltip").attr('hidden','hidden').text('');
	}
	else{

	}
})
$('#_add_category_form').on('submit', function(e){
	e.preventDefault();
	category = $("#_category_name").val();
	if (category == '' || !category || category == null) {
		$(".category-wrapper .alert-tooltip").removeAttr('hidden').text('Category is required!');
		return false;
	}
	$("#_submit_category_btn").attr('disabled','disabled').text('Saving...');
	$.ajax({
		url: base_url+'api/v1/blog/_add_category',
		type: 'POST',
		data: {category:category},
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			Swal.fire({
			  	icon: 'success',
			  	title: 'Success!',
			 	text: res.data.message,
			})
			$("#_category_name").val('');
			$('#_add_category_form_div').attr('hidden','hidden');
			_getCategoryTbl();
		}
		else{
			$(".category-wrapper .alert-tooltip").removeAttr('hidden','hidden').text(res.data.message);
		}
		$("#_submit_category_btn").removeAttr('disabled','disabled').text('Save');

	})
})
$('#_category_tbl_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    _getCategoryTbl(page_no);
});
$('#_image_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    _showImages(page_no);
});
function _getCategoryTbl(page_no){
	$("#_category_tbl").html("<tr class='text-center'><td colspan='3'>Loading data...</td></tr>");

	let params = new URLSearchParams({'page_no':page_no});
	fetch(base_url+'api/v1/blog/_get_category?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		$('#_category_tbl_pagination').html(res.pagination);
		string ='';
		if (res.result.length > 0) {
			for(var i = 0; i < res.result.length; i++){
				string +='<tr>'
					+'<td>'+res.result[i].name+'</td>'
					+'<td>'+res.result[i].created_at+'</td>'
					+'<td><a href="#" class="btn btn-sm font-11 btn-danger" onclick="_deleteCategory(\''+res.result[i].id+'\',\''+page_no+'\')"><i class="uil-trash-alt"></i> Delete</a></td>'
				+'</tr>'
			}
			$('#_category_tbl').html(string);
		}
		else{
			$("#_category_tbl").html("<tr class='text-center'><td colspan='3'>"+res.message+"</td></tr>");
		}
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}

function _deleteCategory(id, page_no){
	Swal.fire({
		title: 'Delete?',
	 	icon: 'warning',
	 	text: 'Are you sure to delete this category?',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
	  	if (result.isConfirmed) {
	  		$.ajax({
				url: base_url+'api/v1/blog/_delete_category',
				type: 'POST',
				dataType: 'JSON',
				data: {id:id},
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
				_getCategoryTbl(page_no);
			})
	  	} 
	})
}
function _error403(){
	Swal.fire({
		icon: 'error',
		title: 'Oh Snap!',
		text: 'Something went wrong! Refresh this page and try again!',
	})
}
var multiple_tags = new Array;
var tag_count = 0;
$("#_add_tags_btn").on('click', function(){
	// e.preventDefault();
	tags = $("#_add_tags").val();

	const isInArray = multiple_tags.includes(tags);
	if (!tags || tags == '') {
		$("#_tags_div .alert-tooltip").text('Tags should not be empty!!').removeAttr('hidden', 'hidden');
	}
	else if (isInArray == true) {
		$("#_tags_div .alert-tooltip").text('Already Added!').removeAttr('hidden', 'hidden');
	}
	else{
		tag_count++;
		$("#_added_input_tags").append('<input name="tags[]" type="hidden" value="'+tags+'" class="form-control hidden-tags input-tag-'+tag_count+'" id="">');
		$("#_added_tags_show").append('<span class="multiple-tags" id="_tag_'+tag_count+'">'+tags+' <span onclick="_removeTag('+tag_count+')" class="remove-tag-icon"><i class="uil-times"></i></span></span>');
		$("#_add_tags").val('');
		$("#_tags_div .alert-tooltip").text('').attr('hidden', 'hidden');
	}

	_multipleTags(tags);
})
function _multipleTags(tags){
	multiple_tags.push(tags);
}

function _removeTag(tag_count){
	tag = $(".input-tag-"+tag_count).val();
	multiple_tags = multiple_tags.filter(item => item !== tag); // remove item
	$("#_tag_"+tag_count).attr('hidden','hidden');
	$(".input-tag-"+tag_count).html('');
}

$('#_blog_tbl_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    _showArticles(page_no);
});
$("#_search_article_form").on('submit', function(e){
	e.preventDefault();
	search = $("#_search").val();
	page_no = 1;
	let params = new URLSearchParams({'page_no':page_no, search:search});
	fetch(base_url+'api/v1/blog/_search_article?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayBlogs(page_no, res.result, res.pagination, res.count);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
})
function _refreshBlogList(){
	$("#_search").val('');
	_showArticles(1);

}
function _showArticles(page_no){
	$("#_blog_tbl").html("<tr class='text-center'><td colspan='5'>Loading data...</td></tr>");
	search = $("#_search").val();

	let params = new URLSearchParams({'page_no':page_no, search:search});
	fetch(base_url+'api/v1/blog/_get_list?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayBlogs(page_no, res.result, res.pagination, res.count);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
function _displayBlogs(page_no, result, pagination, count){
	check_stat = '';
	string ='';
	$("#_blog_count").text('Count: '+count)
	$('#_blog_tbl_pagination').html(pagination);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){
			if (result[i].status == 'published') {
				check_stat = 'checked';
			}
			else{
				check_stat = '';
			}

			string +='<tr>'
				+'<td width="500"><a href="'+result[i].url+'" target="_blank">'+result[i].title+'</a></td>'
				+'<td>'
	               	+'<input onchange="_statusCheckBox(\''+result[i].article_pub_id+'\',\''+page_no+'\')" type="checkbox" id="_checkbox_status_'+result[i].article_pub_id+'" '+check_stat+' data-switch="success"/>'
	               	+'<label for="_checkbox_status_'+result[i].article_pub_id+'" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>'
	            +'</td>'
				+'<td>'+result[i].created_at+'</td>'
				+'<td>'
					+'<a href="'+base_url+'blog/edit/'+result[i].article_pub_id+'" class="font-16 text-secondary" ><i class="uil-edit"></i> </a>'
					+'<a href="#delete" class="font-16 text-secondary" onclick="_deleteArticle(\''+result[i].article_pub_id+'\',\''+page_no+'\')"><i class="uil-trash-alt"></i> </a>'
				+'</td>'
			+'</tr>'
		}
		$('#_blog_tbl').html(string);
	}
	else{
		$("#_blog_tbl").html("<tr class='text-center'><td colspan='5'>No records found!</td></tr>");
	}
}
function _statusCheckBox(id, page_no){
    csrf_token = $("#_global_csrf").val()
	status = '';
	if(!$("#_checkbox_status_"+id).is(':checked') ) {
		status = 'draft';
    }
    else{
		status = 'published';
    }
    $.ajax({
		url: base_url+'api/v1/blog/_update_article_status',
		type: 'POST',
		dataType: 'JSON',
		data: {status:status,id:id, csrf_token:csrf_token},
        statusCode: {
		403: function() {
			  	_error403();
			}
		}
	})
	.done(function(res) {
		_showArticles(page_no);
		_csrfNonce();
	})
	.fail(function() {
		_csrfNonce();
	})
}
$("#_update_blog_btn").on('click', function(e){
	e.preventDefault();
	let content = window.parent.tinymce.get('_new_blog_content').getContent();
	let lead = window.parent.tinymce.get('_lead').getContent();
	let formData = new FormData($("#_edit_blog_form")[0]);
	formData.append('content', content);
	formData.append('lead', lead);

	$("#_update_blog_btn").text('Updating Article...').attr('disabled', 'disabled');
	$.ajax({
		url: base_url+'api/v1/blog/_update_blog',
		type: 'POST',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
		403: function() {
			_error403();
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			Swal.fire({
			  	icon: 'success',
			  	title: 'Success!',
			 	text: res.data.message,
			})
		}
		else{
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	html: res.data.message,
			})
		}
		_csrfNonce();
		$("#_update_blog_btn").text('Update Article').removeAttr('disabled', 'disabled');
	})
	.fail(function(){
		_csrfNonce();
		$("#_update_blog_btn").text('Update Article').removeAttr('disabled', 'disabled');
	})
})
function _deleteArticleTag(id){
	csrf_token = $("#_global_csrf").val();
	$.ajax({
		url: base_url+'api/v1/blog/_remove_tag',
		type: 'POST',
		data: {id:id,csrf_token:csrf_token}
	})
	.done(function(res) {
		$("#_tag_"+id).attr('hidden','hidden');
		_csrfNonce()
	})
	.fail(function(){
		_csrfNonce()
	})
}
$("#_add_tags_btn_update_form").on('click', function(){
	csrf_token = $("#_global_csrf").val();
	tag = $("#_add_tags").val();
	id = $("#_id").val();
	$.ajax({
		url: base_url+'api/v1/blog/_add_tag',
		type: 'POST',
		data: {id:id, tag:tag,csrf_token:csrf_token}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			$("#_added_tags_show").append('<span class="multiple-tags" id="_tag_'+res.data.id+'">'+tag+'<span onclick="_deleteArticleTag('+res.data.id+')" class="remove-tag-icon"><i class="uil-times"></i></span></span>');
			$("#_tags_div .alert-tooltip").text('').attr('hidden', 'hidden');
			$("#_add_tags").val('');
		}
		else{
			$("#_tags_div .alert-tooltip").text(res.data.message).removeAttr('hidden', 'hidden');
		}
		_csrfNonce()
	})
	.fail(function() {
		_csrfNonce();
	})
})


function _deleteArticle(id, page_no){
	Swal.fire({
		title: 'Delete?',
	 	icon: 'warning',
	 	text: 'Are you sure to delete this article?',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
	  	if (result.isConfirmed) {
	  		$.ajax({
				url: base_url+'api/v1/blog/_delete_article',
				type: 'POST',
				dataType: 'JSON',
				data: {id:id},
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
				_showArticles(page_no);
			})
	  	} 
	})
}
var _article_img;
_article_img = $("#_article_thumbnail").croppie({
    viewport: {
        width: 500,
        height: 313,
        type: 'square'
    },
    boundary: {
        width: 500,
        height: 313
    },
});
function readURL(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	            
	    reader.onload = function (e) {
			$('#_article_thumbnail').addClass('ready');
		    _article_img.croppie('bind', {
		        url: e.target.result
		    }).then(function(){
		    });
		}
	   reader.readAsDataURL(input.files[0]);
	}
	else {
		swal("Sorry - you're browser doesn't support the FileReader API");
	}
}
$("#_new_blog_btn").on('click', function(e){
	e.preventDefault();

	let content = window.parent.tinymce.get('_new_blog_content').getContent();
	let lead = window.parent.tinymce.get('_lead').getContent();
	form = $("#_new_blog_form")[0];
	let formData = new FormData(form);

	if (!content || content == '') {
		Swal.fire({
			icon: 'error',
		 	title: 'Error!',
			html: "Content should not be empty!",
		})
		return false;
	}

	// if (!lead || lead == '') {
	// 	Swal.fire({
	// 		icon: 'error',
	// 	 	title: 'Error!',
	// 		html: "Lead should not be empty!",
	// 	})
	// 	return false;
	// }
	
	formData.append('content', content);
	formData.append('lead', lead);
	$("#_new_blog_btn").text('Saving Article...').attr('disabled', 'disabled');

	_article_img.croppie('result', {
		type: 'canvas',
		size: { width: 800, height: 500 },
		format: 'webp',
		quality: 0.8,
	}).then(function (cropped_img) {
		formData.append('article_image', cropped_img);
			if (!cropped_img || cropped_img == '') {
			Swal.fire({
				icon: 'error',
			 	title: 'Error!',
				html: "Image is required!",
			})
			return false;
		}

		$.ajax({
			url: base_url+'api/v1/blog/_add_blog',
			type: 'POST',
			data: formData,
			cache       : false,
		    contentType : false,
		    processData : false,
		    statusCode: {
			403: function() {
				_error403();
				}
			}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				Swal.fire({
				  	icon: 'success',
				  	title: 'Success!',
				 	text: res.data.message,
				})
				let timerInterval
					Swal.fire({
					  	title: 'Success',
					  	html: res.data.message,
					  	timer: 3000,
					  	timerProgressBar: true,
					  	allowOutsideClick:false,
					  	didOpen: () => {
						    Swal.showLoading()
					  	},
					}).then((result) => {
						if (result.dismiss === Swal.DismissReason.timer) {
							location.href=res.data.url;
						}
					})
			}
			else{
				Swal.fire({
				  	icon: 'error',
				  	title: 'Error!',
				 	html: res.data.message,
				})
			}
			$("#_new_blog_btn").text('Save Article').removeAttr('disabled', 'disabled');
		})
        .fail(function() {
			$("#_new_blog_btn").text('Save Article').removeAttr('disabled', 'disabled');
        })
		_csrfNonce();
	});
	
})
$("#_update_image_form").on('submit', function(e){
	e.preventDefault();
	let formData = new FormData(this);
	id = $("#_article_id").val();
	csrf_token = $("#_global_csrf").val();
	var file = $("#_article_img")[0].files[0];
	var fileType = file["type"];
	var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/webp", "image/jpg"];
	if ($.inArray(fileType, validImageTypes) < 0) {
	    Swal.fire({
			icon: 'error',
			title: 'Error!',
			html: 'File not an image!',
		})
		 return false;
	}

	_article_img.croppie('result', {
		type: 'canvas',
		size: { width: 800, height: 500 },
		format: 'webp',
		quality: 0.8,
	}).then(function (cropped_img) {
		formData.append('id', id);
		formData.append('article_img', cropped_img);

		$("#_update_image_btn").text('Updating Image...').attr('disabled', 'disabled');
		$.ajax({
			url: base_url+'api/v1/blog/_update_image',
			type: 'POST',
			data: {'article_image':cropped_img, 'id':id,csrf_token:csrf_token},
			// cache       : false,
		    // contentType : false,
		    // processData : false,
		    statusCode: {
			403: function() {
					_error403();
				}
			}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				Swal.fire({
				  	icon: 'success',
				  	title: 'Success!',
				 	text: res.data.message,
				})
            	$('#article_image').croppie('destroy');
			}
			else{
				Swal.fire({
				  	icon: 'error',
				  	title: 'Error!',
				 	html: res.data.message,
				})
			}
			_csrfNonce();
			$("#_update_image_btn").text('Update Image').removeAttr('disabled', 'disabled');
		})
	});
})

function _viewArticle(article_pub_id){
	let params = new URLSearchParams({'article_pub_id':article_pub_id});
	fetch(base_url+'api/v1/blog/_check_article?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		window.open(res.data.url);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
$("#_upload_more_images").on('click', () => {
	$("#_images_modal").modal('show')
})
var more_img;
more_img = $("#_more_article_thumbnail").croppie({
    viewport: {
        width: 300,
        height: 188,
        type: 'square'
    },
    boundary: {
        width: 300,
        height: 188
    },
});
function readMoreImage(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	            
	    reader.onload = function (e) {
			$('#_more_article_thumbnail').addClass('ready');
		    more_img.croppie('bind', {
		        url: e.target.result
		    }).then(function(){
		    });
		}
	   reader.readAsDataURL(input.files[0]);
	}
	else {
		swal("Sorry - you're browser doesn't support the FileReader API");
	}
}
$("#_more_image_form").on('submit', function(e){
	e.preventDefault();
	let formData = new FormData(this);
	csrf_token = $("#_global_csrf").val();

	var file = $("#_more_img")[0].files[0];
	var fileType = file["type"];
	var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/webp", "image/jpg"];
	if ($.inArray(fileType, validImageTypes) < 0) {
	    Swal.fire({
			icon: 'error',
			title: 'Error!',
			html: 'File not an image!',
		})
		 return false;
	}

	more_img.croppie('result', {
		type: 'canvas',
		size: { width: 800, height: 500 },
		format: 'webp',
		quality: 0.8,
	}).then(function (cropped_img) {
		formData.append('more_image', cropped_img);

		$("#_save_more_image_btn").text('Saving...').attr('disabled', 'disabled');
		$.ajax({
			url: base_url+'api/v1/blog/_add_image',
			type: 'POST',
			data: {'more_image':cropped_img, csrf_token:csrf_token},
		    statusCode: {
			403: function() {
					_error403();
				}
			}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				Swal.fire({
				  	icon: 'success',
				  	title: 'Success!',
				 	text: res.data.message,
				})
            	$('#_more_img').croppie('destroy');
				_showImages(1);
			}
			else{
				Swal.fire({
				  	icon: 'error',
				  	title: 'Error!',
				 	html: res.data.message,
				})
			}
			_csrfNonce();
			$("#_save_more_image_btn").text('Save Image').removeAttr('disabled', 'disabled');
		})
	});
})
function _showImages(page_no){
	$("#_images_tbl").html("<tr class='text-center'><td colspan='3'>Loading data...</td></tr>");
	let params = new URLSearchParams({'page_no':page_no});
	fetch(base_url+'api/v1/images/_get_list?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		let string ='';
		let n = 0;
		let result = res.result;
		$("#_image_count").text('Count: '+res.count)
		$('#_image_pagination').html(res.pagination);
		if (result.length > 0) {
			for(var i = 0; i < result.length; i++){
				n++;
				string +='<tr>'
					+'<td width="300"><img src="'+res.result[i].image+'" width="130"/></td>'
					+'<td>'+res.result[i].created_at+'</td>'
					+'<td>'
						+'<button class="btn btn-xs btn-secondary rounded copy-url" data-clipboard-text="'+res.result[i].image+'" ><i class="uil-copy"></i> Copy</button>'
					+'</td>'
				+'</tr>'
			}
			$('#_images_tbl').html(string);
		}
		else{
			$("#_images_tbl").html("<tr class='text-center'><td colspan='5'>No records found!</td></tr>");
		}
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
