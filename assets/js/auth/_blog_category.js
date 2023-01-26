if (_state == 'blog_category'){
	_getBlogCategory(1, _category);
}
if (_state == 'blog_tags'){
	_getBlogTags(1, _tags);
}	
$('#_category_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    _getBlogCategory(page_no, _category);
});
$('#_tags_pagination').on('click','a',function(e){
    e.preventDefault(); 
    var page_no = $(this).attr('data-ci-pagination-page');
    _getBlogTags(page_no, _tags);
});
function _getBlogCategory(page_no, _category){
	let params = new URLSearchParams({'page_no':page_no, 'category':_category});
	fetch(base_url+'api/v1/article/_get_blog_category?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		string = '';
		result = res.data.result;
		$("#_category_title").html('<h2>'+res.data.category+'</h2>');
		for(var i in result){
			string +='<div class="col-lg-3 mb-4">'
                    +'<a href="'+result[i].url+'" class="text-secondary">'
                        +'<div class="">'
                            +'<img src="'+result[i].article_image+'" class="img-fluid br-10" alt="'+result[i].title+'">'
                            +'<h2 class="font-18 fw-600" >'+result[i].title+'</h2>'
                            +'<span class="text-muted">'+result[i].created_at+'  • '+result[i].min_read+' min read</span>'
                        +'</div>'
                   +' </a>'
                +'</div>';
		}
		$("#_category_pagination").html(res.data.pagination)

		$("#_category_data").html(string)
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
function _getBlogTags(page_no, _tags){
	let params = new URLSearchParams({'page_no':page_no, 'tag':_tags});
	fetch(base_url+'api/v1/article/_get_blog_tags?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		string = '';
		result = res.data.result;
		$("#_tag_title").html('<h2>'+res.data.tag+'</h2>');
		for(var i in result){
			string +='<div class="col-lg-3 mb-4">'
                    +'<a href="'+result[i].url+'" class="text-secondary">'
                        +'<div class="">'
                            +'<img src="'+result[i].article_image+'" class="img-fluid br-10" alt="'+result[i].title+'">'
                            +'<h2 class="font-18 fw-600" >'+result[i].title+'</h2>'
                            +'<span class="text-muted">'+result[i].created_at+'  • '+result[i].min_read+' min read</span>'
                        +'</div>'
                   +' </a>'
                +'</div>';
		}
		$("#_tags_pagination").html(res.data.pagination)

		$("#_tags_data").html(string)
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}