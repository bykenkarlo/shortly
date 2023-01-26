const clipboard = new ClipboardJS('#_copy_url_btn');
clipboard.on('success', function(e) {
	$("#_copy_url_btn").text("Copied!");
	setTimeout(() => {$("#_copy_url_btn").text("Copy");}, 3000)
	e.clearSelection();
});
const alertBox = (text, fade_out) => {
    $("#_custom_alert").removeAttr('hidden','hidden').text(text);
    setTimeout(() => {
        $("#_custom_alert").attr('hidden','hidden');
    }, fade_out);
}
const _copy_shortly = new ClipboardJS('#_copy_shortly');
_copy_shortly.on('success', function(e) {
	e.clearSelection();
    alertBox('Copied URL', 3000);
    
});
const _upload_logo_btn = () => {
    $("#_upload_custom_logo_modal").modal('show')
};
$("#_try_again_btn").on('click', () => {
    $("#_input_url_div").removeClass('hide');
    $("#_copy_url_div").addClass('hide').removeClass('show');
    $("#_shortened_url").val("");
    $("#_input_url").val("");
	$("#_shorten_url_btn").text('Shorten').removeAttr('disabled', 'disabled');
})
const _placeholder = () => {
    placeholder = '';
    placeholder +='<div class="placeholder-glow">'
            +'<div><span class="placeholder col-5"></span><div>'
            +'<span class="placeholder col-7"></span>'
            +'<span class="placeholder col-4"></span>'
            +'<span class="placeholder col-4"></span>'
            +'<span class="placeholder col-6"></span>'
        +'</div>'
    return placeholder;
}
$("#_url_shortener_form").on('submit', function(e) {
    e.preventDefault();
	const long_url = $("#_input_url").val();
    
    if (!long_url || long_url == '' || long_url === null){
        Swal.fire({
            icon: 'warning',
            title: 'Error!',
           html: "URL is required! Try again!",
        });   
        return false;
    }
    let formData = new FormData(this);
	$("#_shorten_url_btn").text('Processing...').attr('disabled', 'disabled');
	$.ajax({
		url: base_url+'api/v1/shortener/_process',
		type: 'POST',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
		403: () => {
			    _error403();
			}
		}
	})
	.done( (res) => {
		if (res.data.status == 'success') {
            $("#_input_url_div").addClass('hide');
            $("#_copy_url_div").removeClass('hide').addClass('show');
            $("#_shortened_url").val(res.data.attribute.url);
	        $("#_shorten_url_btn").text('Shorten URL').removeAttr('disabled', 'disabled');
            $("#_monitor_btn").attr('data-param',res.data.attribute.param)
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
      $("#_shorten_url_btn").text('Shorten URL').removeAttr('disabled', 'disabled');
		_csrfNonce();
    })
})
const isValidUrl = (long_url) => {
    var urlPattern = new RegExp('^(https?:\\/\\/)?'+ // validate protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // validate domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // validate OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // validate port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // validate query string
    '(\\#[-a-z\\d_]*)?$','i'); // validate fragment locator
    return !!urlPattern.test(long_url);
}
$("#_monitor_btn").on('click', () => {
    const param = $("#_monitor_btn").data("param");
    location.href=base_url+'stat/'+param+'';
});

const statistics = (_url_param) => {
	let params = new URLSearchParams({'url_param':_url_param});
	fetch(base_url+'api/v1/shortener/_get_statistics?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
       if(res.data.status == 'disabled'){
            $("#_short_url").html(res.data.short_url+ ' <span id="_edit_url" class="font-16">');
        }
        else if(res.data.status == 'active'){
            $("#_short_url").html(res.data.short_url+ ' <span id="_edit_url" class="pointer-cursor font-16"><i class="uil uil-edit-alt"></i></span>').attr('data-url_param',res.data.url_param).attr('onclick','changeURLModal()');
        }
        generateQrCode(_url_param, res.data.logo_img);
        $("#_referrer_title").html('Referrer'+' <small>(in the last 30 days)</small>');
        $("#_platform_title").html('Platform'+' <small>(in the last 30 days)</small>');
        $("#_browser_title").html('Browser'+' <small>(in the last 30 days)</small>');
        $("#_location_title").html('Location'+' <small>(in the last 30 days)</small>');
        $("#_engagement_overview_title").html('Engagement Overview'+' <small>(in the last 30 days)</small>');
        $("#_copy_url_div").html('<a href="#copy" class="arrow-none card-drop" data-clipboard-target="#_short_url" id="_copy_shortly"><i class="uil-copy"></i></a>')
        $("#_engagement_div").html('<i class="uil uil-chart-bar"></i> <span id="_engagement">'+res.data.total_click+'</span> Total engagements')
        $("#_dl_btn_div").html('<button onclick="downloadQr(\''+res.data.logo_img+'\')" class="btn btn-md rounded btn-light"><i class="uil uil-download-alt"></i> Download</button>');
        $("#_upload_btn_div").html('<button onclick="_upload_logo_btn()" class="btn btn-md rounded btn-light"><i class="uil uil-upload-alt"></i> Upload Logo</button>');
        $("#_qr_code_title").html('<i class="uil-qrcode-scan"></i> QR Code')
        $("#_redirect_title").text('Redirect')
        $("#_created_div").html('<i class="uil uil-calendar-alt"></i> <span id="_created_at" class="font-14">'+res.data.created_at+'</span>');
        $("#_redirect_url").html('<i class="uil uil-link"></i> <a target="_blank" rel="nofollow" class="font-14 c-gray" href="'+res.data.redirect_url+'">'+res.data.redirect_url+'</a>');
		
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
const clickStats = (_url_param, range) => {
    
	let params = new URLSearchParams({'url_param':_url_param, 'range':range});
	fetch(base_url+'api/v1/shortener/_get_click_stats?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		let dates = [];
        let clicks = [];

        if(range == '7_days'){
            $("#_engagement_overview_title").html('Engagement Overview'+' <small> (in the last 7 days)</small>');
        }
        else if(range == '30_days'){
            $("#_engagement_overview_title").html('Engagement Overview'+' <small> (in the last 30 days)</small>');
        }
        else if(range == '1_year'){
            $("#_engagement_overview_title").html('Engagement Overview'+' <small> (in the last 1 year)</small>');
        }
        
        stats = res.data.click_statistics;
        for(var i in stats){
            dates.push(stats[i].date);
            clicks.push(stats[i].clicks);
        }
        _clickStatChart(dates, clicks);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
const referrerStat = (_url_param, range) => {
	let params = new URLSearchParams({'url_param':_url_param, 'range':range});
	fetch(base_url+'api/v1/shortener/_get_referrer_stats?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		let count = [];
        let referrer = [];

        if(range == '7_days'){
            $("#_referrer_title").html('Referrer'+' <small> (in the last 7 days)</small>');
        }
        else if(range == '30_days'){
            $("#_referrer_title").html('Referrer'+' <small> (in the last 30 days)</small>');
        }
        else if(range == '1_year'){
            $("#_referrer_title").html('Referrer'+' <small> (in the last 1 year)</small>');
        }

        stats = res.data.referrer_statistics;
        for(var i in stats){
            count.push(stats[i].count);
            referrer.push(stats[i].referrer);
        }
        _referrerStatChart(count, referrer);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
const browserStat = (_url_param, range) => {
	let params = new URLSearchParams({'url_param':_url_param, 'range':range});
	fetch(base_url+'api/v1/shortener/_get_browser_stats?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		let count = [];
        let browser = [];

        if(range == '7_days'){
            $("#_browser_title").html('Browser'+' <small> (in the last 7 days)</small>');
        }
        else if(range == '30_days'){
            $("#_browser_title").html('Browser'+' <small> (in the last 30 days)</small>');
        }
        else if(range == '1_year'){
            $("#_browser_title").html('Browser'+' <small> (in the last 1 year)</small>');
        }

        stats = res.data.browser_statistics;
        for(var i in stats){
            count.push(stats[i].count);
            browser.push(stats[i].browser);
        }
        _browserStatChart(count, browser);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
const platformStat = (_url_param, range) => {
	let params = new URLSearchParams({'url_param':_url_param, 'range':range});
	fetch(base_url+'api/v1/shortener/_get_platform_stats?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		let count = [];
        let platform = [];

        if(range == '7_days'){
            $("#_platform_title").html('Platform'+' <small> (in the last 7 days)</small>');
        }
        else if(range == '30_days'){
            $("#_platform_title").html('Platform'+' <small> (in the last 30 days)</small>');
        }
        else if(range == '1_year'){
            $("#_platform_title").html('Platform'+' <small> (in the last 1 year)</small>');
        }

        stats = res.data.platform_statistics;
        for(var i in stats){
            count.push(stats[i].count);
            platform.push(stats[i].platform);
        }
        _platformStatChart(count, platform);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
const locationStat = (_url_param, range) => {
    const loc_chart = _placeholder();
    $("#_location_chart").html(loc_chart);
	let params = new URLSearchParams({'url_param':_url_param, 'range':range});
	fetch(base_url+'api/v1/shortener/_get_location_stats?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		let count = [];
        let country = [];
        let string = "";

        if(range == '7_days'){
            $("#_location_title").html('Location'+' <small> (in the last 7 days)</small>');
        }
        else if(range == '30_days'){
            $("#_location_title").html('Location'+' <small> (in the last 30 days)</small>');
        }
        else if(range == '1_year'){
            $("#_location_title").html('Location'+' <small> (in the last 1 year)</small>');
        }
        stats = res.data.country_statistics;
        for(var i in stats){
            count.push(stats[i].count);
            country.push(stats[i].country);

            string +='<div class="col-2 col-lg-1 col-md-1 " style="margin-top:-2px;">'
                    +'<label class="font-13" for="">'+stats[i].count+'</label>'
                +'</div>'
                +'<div class="col-10 col-lg-3 col-md-3 " style="margin-top:-2px;">'
                +'<label class="font-13" for="">'+stats[i].country+'</label>'
            +'</div>'
            +'<div class="col-12 col-lg-8 col-md-8  mb-2">'
                +'<div class="progress progress-lg">'
                    +'<div class="progress-bar bg-success" role="progressbar" style="width: '+stats[i].percentage+'%" aria-valuenow="'+stats[i].country+'" aria-valuemin="0" aria-valuemax="100"></div>'
                +'</div>'
           +' </div>';
        }
        $("#_location_chart").html(string);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
const _clickStatChart = (dates, clicks) => {
    let clicks_chart = _placeholder();
    $("#_clicks_overview").html(clicks_chart);
    if (click_statistics_chart) {
        click_statistics_chart.destroy();
    }
    const ctx = document.getElementById('_clicks_overview');
    options = '';
    click_statistics_chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'URL Clicks',
                data: clicks,
                fill: true,
                backgroundColor: 'rgba(5, 203, 98, .2)',
                borderColor: 'rgba(5, 203, 98, 1)',
                borderJoinStyle: 'round',
                borderWidth: 1.5,
                tension: .3
            }]
        },
        options: {
           
            scales: {
                x: {
                    grid: {
                      display: false,
                    }
                },
                y: {
                    grid: {
                      display: false
                    }
                },
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
}
const _referrerStatChart = (count, referrer) => {
    
    if (referrer_stat_chart) {
        referrer_stat_chart.destroy();
    }  
    color = [];
    color = [
        'rgb(5, 203, 98)',
        'rgb(28, 125, 215)',
        'rgb(5, 215, 213)',
        'rgb(5, 138, 215)',
        'rgb(5, 203, 98)',
        'rgb(28, 215, 156)',
        'rgb(75, 192, 192)',
        'rgb(215, 28, 151)',
        'rgb(89, 215, 28)',
        'rgb(28, 215, 76)',
        'rgb(28, 215, 156)',
        'rgb(54, 162, 235)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(153, 102, 25)',
        'rgb(138, 28, 215)',
        'rgb(215, 28, 151)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 98)',
        'rgb(215, 28, 54)',
        'rgb(215, 59, 28)',
        'rgb(215, 129, 28)',
        'rgb(215, 178, 28)',
        'rgb(201, 203, 207)',
    ];
    for (var i=0;i<referrer.length;i++) {
        color.push(referrer[i].referrer); 
    }
    const ctx = document.getElementById('_referrer_overview');
    referrer_stat_chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: referrer,
            datasets: [{
                label: 'Referrer',
                data: count,
                backgroundColor: color,
                borderColor: color,
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    grid: {
                      display: false,
                    }
                },
                y: {
                    grid: {
                      display: false
                    }
                },
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
}
const _browserStatChart = (count, browser) => {
    if (browser_stat_chart) {
        browser_stat_chart.destroy();
    }  
    color = [];
    
    color = [
        'rgb(5, 138, 215)',
        'rgb(28, 215, 156)',
        'rgb(5, 203, 98)',
        'rgb(28, 125, 215)',
        'rgb(28, 125, 215)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 151)',
        'rgb(28, 215, 76)',
        'rgb(5, 215, 213)',
        'rgb(215, 28, 54)',
        'rgb(28, 208, 215)',
        'rgb(28, 182, 215)',
        'rgb(28, 125, 215)',
        'rgb(138, 28, 215)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 98)',
        'rgb(215, 59, 28)',
        'rgb(215, 129, 28)',
        'rgb(215, 178, 28)',
        'rgb(195, 215, 28)',
        'rgb(89, 215, 28)',
    ];

    for (var i=0;i<browser.length;i++) {
        color.push(browser[i].browser); 
    }
    const ctx = document.getElementById('_browser_overview');
    browser_stat_chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: browser,
            datasets: [{
                label: '',
                data: count,
                backgroundColor: color,
                borderColor: '#fff',
                hoverOffset: 4
            }],
        },
        options: {
            layout: {
                padding: 20
            },
           
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
}
const _platformStatChart = (count, platform) => {
    if (platform_stat_chart) {
        platform_stat_chart.destroy();
    }  
    color = [];
    
    color = [
        'rgb(28, 215, 156)',
        'rgb(5, 203, 98)',
        'rgb(28, 125, 215)',
        'rgb(5, 215, 213)',
        'rgb(5, 138, 215)',
        'rgb(5, 203, 98)',
        'rgb(28, 215, 156)',
        'rgb(195, 215, 28)',
        'rgb(215, 28, 151)',
        'rgb(5, 138, 215)',
        'rgb(89, 215, 28)',
        'rgb(28, 215, 76)',
        'rgb(28, 215, 156)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(153, 102, 25)',
        'rgb(138, 28, 215)',
        'rgb(215, 28, 151)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 98)',
        'rgb(215, 28, 54)',
        'rgb(215, 59, 28)',
        'rgb(215, 129, 28)',
        'rgb(215, 178, 28)',
        'rgb(201, 203, 207)',
    ];

    for (var i=0;i<platform.length;i++) {
        color.push(platform[i].platform); 
    }
    const ctx = document.getElementById('_platform_overview');
    platform_stat_chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: platform,
            datasets: [{
                label: 'Platform',
                data: count,
                backgroundColor: color,
                borderColor: '#fff',
                borderWidth: 1,
                hoverOffset: 4
            }],
        },
        options: {
            layout: {
                padding: 20
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
}
const generateQrCode = (_url_param, image) => {
    $("#_qr_code").html('');

    let _img;
    if(image !== '' || image ){
        _img = image
    }
    else{
        _img = base_url+"assets/images/logo/logo.png";
    }
    const qrCode = new QRCodeStyling({
        width: 250,
        height: 250,
        type: "png",
        data: base_url+''+_url_param,
        image: _img,
       
        dotsOptions: {
            color: "#000",
            type: "rounded"
        },
        cornersSquareOptions: {
            type: "rounded"
        },
        backgroundOptions: {
            color: "#fff",
        },
        imageOptions: {
            crossOrigin: "anonymous",
            margin: 5
        }
    });
    qrCode.append(document.getElementById("_qr_code"));
}
const downloadQr = (image) => {
    let _img;
    if(image !== '' || image ){
        _img = image
    }
    else{
        _img = base_url+"assets/images/logo/logo.png";
    }

    const qrCode = new QRCodeStyling({
        width: 1000,
        height: 1000,
        type: "png",
        data: base_url+''+_url_param,
        image: _img,
        dotsOptions: {
            color: "#000",
            type: "classy-rounded"
        },
        backgroundOptions: {
            color: "#fff",
        },
        imageOptions: {
            crossOrigin: "anonymous",
            margin: 10,
            imageSize: .5,
        }
    });
    qrCode.download({ name: "shortly_"+_url_param, extension: "png" });
};
var click_statistics_chart;
var referrer_stat_chart;
var browser_stat_chart;
var platform_stat_chart;
var location_stat_chart;
var _logo_img;

if(_state == 'statistics'){
    statistics(_url_param);
    clickStats(_url_param, '30_days');
    referrerStat(_url_param, '30_days');
    platformStat(_url_param, '30_days');
    locationStat(_url_param, '30_days');
    browserStat(_url_param, '30_days');
    _logo_img = $("#_logo_thumbnail").croppie({
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 200,
            height: 200
        }
    });

}
const _browserPlatformStat = (_url_param, range) =>{
    platformStat(_url_param, range);
    browserStat(_url_param, range);
}

const readImageURL = (input) => {
	if (input.files && input.files[0]) {
	    const img_reader = new FileReader();
	    img_reader.onload = function (e) {
			$('#_logo_thumbnail').addClass('ready');
                _logo_img.croppie('bind', {
			        url: e.target.result
			    }).then(function(){
		    });
		}
	   img_reader.readAsDataURL(input.files[0]);
	}
	else {
		swal("Sorry - you're browser doesn't support the FileReader API");
	}
}
$("#_upload_img_form").on('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);
    _logo_img.croppie('result', {
		type: 'canvas',
		size: { width: 500, height: 500 },
	}).then(function (cropped_img) {
		formData.append('logo_img', cropped_img);
        
		var file = $("#_logo_img")[0].files[0];
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
        $("#_upload_btn").text('Uploading...').attr('disabled','disabled');
		$.ajax({
            url: base_url+'api/v1/shortener/_upload_logo',
            type: 'POST',
            data: formData,
            cache       : false,
            contentType : false,
            processData : false,
            statusCode: {
            403: () => {
                    _error403();
                }
            }
        })
        .done( (res) => {
            if (res.data.status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    html: res.data.message,
              });
                generateQrCode(res.data.attribute.url_param, res.data.attribute.image);
                $("#_upload_custom_logo_modal").modal('hide');
                $("#_upload_btn").text('Upload').removeAttr('disabled','disabled');
                $("#_dl_btn_div").html('<button onclick="downloadQr(\''+res.data.attribute.image+'\')" class="btn btn-md rounded btn-light"><i class="uil uil-download-alt"></i> Download</button>');
            }
            else{
                Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                     html: res.data.message,
                });
                $("#_upload_btn").text('Upload').removeAttr('disabled','disabled')
            }
            _csrfNonce();
        })
        .fail(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: "Something went wrong! Please refresh the page and Try again!",
            });
            _csrfNonce();
            $("#_upload_btn").text('Upload').removeAttr('disabled','disabled')
        }) 
	})
})
$("#_close_btn").on('click', () => {
    $("#_upload_custom_logo_modal").modal('hide');
})
$("#_email_us").on('click', () => {
	fetch(base_url+'api/v1/email/_get?', {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		location.href="mailto:"+res.data.email_address
	})
	.catch((error) => {
		console.error('Error:', error);
	});
})
const changeURLModal = () => {
    const param = $("#_short_url").data("url_param");
    $("#_edit_url_modal").modal('show');
    $("#_edit_url_param").val(param);
    $("#_url_param_view").text(param)
}
$("#_close_update_url_btn").on('click', () => {
    $("#_edit_url_modal").modal('hide');
});
$("#_edit_url_param").keyup(function(){
    customized_url = $(this).val();
    $("#_url_param_view").text(customized_url)
});
$("#_edit_url_form").on('submit', function(e){
    e.preventDefault();
    let edit_url_param = $("#_edit_url_param").val();
    let url_param = $("#_url_param").val();
  	let text_count = $("#_edit_url_param").val().length;
    if(edit_url_param == url_param){
        return false;
    }
    else if(text_count < 4){
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html:  "Only a minimum of 4 characters is allowed!",
        });
        return false;
    }
    else if(text_count > 18){
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html:  "Only a maximum of 18 characters is allowed!",
        });
        return false;
    }
    else if(!edit_url_param || edit_url_param == ''){
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html:   "Input cannot be empty!",
        });
        return false;
    }
    let formData = new FormData(this);

    $("#_customize_url_btn").text('Updating...').attr('disabled','disabled')
    $.ajax({
        url: base_url+'api/v1/shortener/_customize_url',
        type: 'POST',
        data: formData,
        cache       : false,
        contentType : false,
        processData : false,
        statusCode: {
        403: () => {
                _error403();
            }
        }
    })
    .done( (res) => {
        if (res.data.status == 'success') {
            location.href=res.data.attribute.new_url
        }
        else{
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: res.data.message,
            });
            $("#_customize_url_btn").text('Update').removeAttr('disabled','disabled')
        }
        _csrfNonce();
    })
    .fail(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: "Something went wrong! Please refresh the page and Try again!",
        });
        _csrfNonce();
        $("#_customize_url_btn").text('Update').removeAttr('disabled','disabled')
    }) 
});
$("#_check_url_stat_btn").on('click', () => {
    $("#_url_stat_modal").modal('show');
});