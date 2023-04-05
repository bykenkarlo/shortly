const clipboard = new ClipboardJS('#_copy_url_btn');
const clipboard2 = new ClipboardJS('#_copy_secret');
const clipboard3 = new ClipboardJS('.acct_copy_url_btn');

clipboard.on('success', function(e) {
	$("#_copy_url_btn").text("Copied!");
	setTimeout(() => {$("#_copy_url_btn").text("Copy");}, 2000)
	e.clearSelection();
});
clipboard2.on('success', function(e) {
	$("#_copy_secret").text("Copied!");
	setTimeout(() => {$("#_copy_secret").text("Copy");}, 2000)
	e.clearSelection();
});
clipboard3.on('success', function(e) {
	$(".acct_copy_url_btn").html('<i class="uil uil-copy"></i> Copied!');
	setTimeout(() => {$(".acct_copy_url_btn").html('<i class="uil uil-copy"></i> Copy');}, 2000)
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
	let long_url = $("#_input_url").val();
    let formData = new FormData(this);
    if (!long_url || long_url == '' || long_url === null){
        Swal.fire({
            icon: 'warning',
            title: 'Error!',
           html: "URL is required! Try again!",
        });   
        return false;
    }
    _checkLink(long_url, formData);
    $("#_shorten_url_btn").text('Processing...').attr('disabled', 'disabled');
})
function _checkLink(long_url, formData){
    let api_key =  "AIzaSyCm_T4r1vS1qL-db7RKqjc22xg9OaYo-a8"; 
        let googleURL = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key="+api_key;
        let payload =
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
                {"url": ""+long_url+""},
              ]
            }
        };
        $.ajax({
            url: googleURL,
            dataType: "json",
            type: 'POST',
            contentType: "applicaiton/js on; charset=utf-8",
            data: JSON.stringify(payload),
            statusCode: {
                 403: () => {
                     _error403();
                 }
             }
         })
         .done( (res) => {
            if(jQuery.isEmptyObject(res)){
                console.log("not_malware");
                processURLShortener(formData);
                console.log("No malware detected!");
            }
            else {
            // if(res.matches[0].threatType == 'MALWARE' || res.matches[0].threatType == 'SOCIAL_ENGINEERING' || res.matches[0].threatType == 'POTENTIALLY_HARMFUL_APPLICATION' || res.matches[0].threatType == 'UNWANTED_SOFTWARE'){
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: "The URL is labeled as unsafe and malicious by Google!",
                }); 
                console.log("Malware detected!");
            }
            $("#_shorten_url_btn").text('Shorten URL').removeAttr('disabled', 'disabled');
         })
}
function processURLShortener(formData){
    
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
        $("#_shorten_url_btn").text('Shorten URL').removeAttr('disabled', 'disabled');
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
}

const checkLink = (long_url) => {
	let api_key =  "AIzaSyCm_T4r1vS1qL-db7RKqjc22xg9OaYo-a8"; 
	let googleURL = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key="+api_key;
	let payload =
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
			{"url": ""+long_url+""},
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
		if(res.matches[0].threatType == 'MALWARE'){
			return res.matches[0].threatType;
		}
        else{
            return false;
        }
	 })
  }
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
        $("#_referrer_title").html('Referrer');
        $("#_platform_title").html('Platform');
        $("#_browser_title").html('Browser');
        $("#_location_title").html('Location');
        $("#_engagement_overview_title").html('Engagement Overview');
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
const clickStats = (_url_param, from, to) => {
    
	let params = new URLSearchParams({'url_param':_url_param, 'from':from, 'to':to});
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
const referrerStat = (_url_param, from, to) => {
	let params = new URLSearchParams({'url_param':_url_param, 'from':from, 'to':to});
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
const browserStat = (_url_param, from, to) => {
	let params = new URLSearchParams({'url_param':_url_param, 'from':from, 'to':to});
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
const platformStat = (_url_param, from, to) => {
	let params = new URLSearchParams({'url_param':_url_param,'from':from, 'to':to});
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
const locationStat = (_url_param, from, to) => {
    const loc_chart = _placeholder();
    $("#_location_chart").html(loc_chart);
	let params = new URLSearchParams({'url_param':_url_param, 'from':from, 'to':to});
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
    $("#loader").attr('hidden','hidden');
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
    qrCode.download({ name: "shortly_"+_url_param, extension: "png" });
};
const generateAcctQrCode = (_url_param, image) => {
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
const downloadAccountQr = (image, url_param) => {
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
        data: base_url+''+url_param,
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
    qrCode.download({ name: "shortly_"+url_param, extension: "png" });
};
var click_statistics_chart;
var referrer_stat_chart;
var browser_stat_chart;
var platform_stat_chart;
var location_stat_chart;
var _logo_img;

$("#_sort_by_date").on('click', () => {
    from = $('#_select_date').data('daterangepicker').startDate;
	to = $('#_select_date').data('daterangepicker').endDate;
    clickStats(_url_param, from, to );
    referrerStat(_url_param, from, to );
    platformStat(_url_param, from, to );
    locationStat(_url_param, from, to );
    browserStat(_url_param, from, to );
})
if(_state == 'statistics'){
    statistics(_url_param);
    
    from = $('#_select_date').data('daterangepicker').startDate;
	to = $('#_select_date').data('daterangepicker').endDate;

    clickStats(_url_param, from, to );
    referrerStat(_url_param, from, to );
    platformStat(_url_param, from, to );
    locationStat(_url_param, from, to );
    browserStat(_url_param, from, to );

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
$("#_create_account_btn").on('click', () => {
    $("#loader").removeAttr('hidden','hidden')
    generateSecretkey(_url_param);
})
$("#_mb_create_account_btn").on('click', () => {
    $("#loader").removeAttr('hidden','hidden')
    generateSecretkey(_url_param);
})
$("#_close_register_btn").on('click', () => {
	$("#_create_account_modal").modal('hide');
    $("#_registration_form input").val('')
})
const generateSecretkey = (_url_param) => {
	let params = new URLSearchParams({'url_param':_url_param});
	fetch(base_url+'api/v1/account/_secret_key_generator?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
        if(res.data.status == 'success'){
            $("#_secret_key").val(res.data.key);
            $("#_create_account_modal").modal('toggle');
        }
        else if(res.data.status == 'error'){
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: res.data.message,
            });
        }
        $("#loader").attr('hidden','hidden')
	})
	.catch((error) => {
		console.error('Error:', error);
	});

}
$("#_registration_form").on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
	$("#_register_btn").text('Processing...').attr('disabled', 'disabled');
	$("#_close_register_btn").attr('disabled', 'disabled');
	$.ajax({
		url: base_url+'api/v1/account/_register',
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
        console.log()
		if (res.data.status == 'success') {
            Swal.fire({
				icon: 'success',
				title: 'Success!',
				html:  res.data.message,
				allowOutsideClick: false,
				confirmButtonText: "Refresh Page!"
			}).then((result) => {
			  	if (result.isConfirmed) {
			  		window.location.href = res.data.url;
			  	} 
			})
            
	        $("#_create_account_modal").modal('hide');
		}
        else if(Object.values(res.data.message)[0]){
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	html: Object.values(res.data.message)[0],
			});
		}
		else{
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	html: res.data.message,
			});
		}
        $("#_register_btn").text('Create').removeAttr('disabled', 'disabled');
        $("#_close_register_btn").removeAttr('disabled', 'disabled');
		_csrfNonce();
	})
    .fail(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: "Something went wrong! Please refresh the page and Try again!",
        });
        $("#_register_btn").text('Create').removeAttr('disabled', 'disabled');
	    $("#_close_register_btn").removeAttr('disabled', 'disabled');
		_csrfNonce();
    })
})


const getURLs = () => {
	fetch(base_url+'api/v1/account/_get_urls?', {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		string = '';
        result =  res.data.result;
        count = 1;
        title = '';
        for(var i in result){
            link_title = result[i].title;
            if(link_title !== ''){
                title = link_title;
            }
            else{
                title = result[i].url_param;
            }
            string +='<div class="list-group-item list-group-item-action cursor-pointer param_'+count+'" id="_param_'+result[i].url_param+'"  data-param="'+result[i].url_param+'" onclick="_getURLData(\''+result[i].url_param+'\')">'
                        +'<div class="float-end font-12" id="_stat_engagement"> '+result[i].total_click+' <span class="uil uil-chart-bar"></span></div>'
                        +'<small class="font-11">'+result[i].created_at+'</small>'
                        +'<h3 class="font-18 fw-600 mt--5">'+title+'</h3>'
                        +'<div class="font-13 text-success mt--10">'+result[i].short_url+' </div>'
                 +'</div>'
                count++;
        }
        $("#url_list").html(string)
        f_param = $(".param_1").attr('data-param');
        _getURLData(f_param);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
const _getURLData = (url_param) => {
    $("#loader").removeAttr('hidden','hidden');
    params = new URLSearchParams({'url_param':url_param});
	fetch(base_url+'api/v1/account/_get_url_data?'+params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
        $('html, body').animate({scrollTop:$('#stat_view').position().top}, 'slow');
        $("#_acct_copy_url_btn").attr('data-clipboard-text',base_url+''+url_param)
        $(".acct_copy_url_btn").attr('data-clipboard-text',base_url+''+url_param)
        $("#url_list div").removeClass('active')
        $("#_param_"+url_param).addClass('active');
        $(".edit_url_btn").attr('onclick','editCustomURL(\''+url_param+'\')')
        $(".qr_url").attr('data-param',url_param)
		$("#_select_date").val(res.data.select_date)
		$("#_su_title").text(res.data.title)
		$("#_su_engagement").text(res.data.total_click)
		$("#_su_created_at").text(res.data.created_at)
		$("#_su_redirect_url").html(' <a id="" target="_blank" rel="nofollow" class="font-14 c-gray" href="'+res.data.redirect_url+'">'+res.data.redirect_url+'</a>')
        $("#_su_sort_by_date").attr('data-param',url_param)
        $("#_img_logo").val(res.data.logo_image);
        setTimeout(function() {
            from = $('.select-date').data('daterangepicker').startDate;
            to = $('.select-date').data('daterangepicker').endDate;
            clickStats(url_param, from, to );
            referrerStat(url_param, from, to );
            platformStat(url_param, from, to );
            locationStat(url_param, from, to );
            browserStat(url_param, from, to );
        }, 1000);
        $("#loader").attr('hidden','hidden');
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
if(_state == 'account_dashboard'){
    getURLs();
}
$("#_su_sort_by_date").on('click', () => {
    $("#loader").removeAttr('hidden','hidden');
    _url_param = $("#_su_sort_by_date").attr('data-param');
    from = $('#_select_date').data('daterangepicker').startDate;
	to = $('#_select_date').data('daterangepicker').endDate;
    clickStats(_url_param, from, to );
    referrerStat(_url_param, from, to );
    platformStat(_url_param, from, to );
    locationStat(_url_param, from, to );
    browserStat(_url_param, from, to );
})

$(".qr_url").on('click', function(){
    $("#_logo_thumbnail").attr('src',base_url+'assets/images/thumbnail.webp');
    url_param = $(".qr_url").attr('data-param');
    image = $("#_img_logo").val();
    $("#_dl_btn_div").html('<button type="button" onclick="downloadAccountQr(\''+image+'\',\''+url_param+'\')" class="btn btn-md rounded btn-light"><i class="uil uil-download-alt"></i> Download</button>');
    $("#_upload_btn_div").html('<button type="button"  onclick="_uploatAcctLogoBtn()" class="btn btn-md rounded btn-light"><i class="uil uil-upload-alt"></i> Upload Logo</button>');
    generateAcctQrCode(url_param,image);
    $('.url-param').val(url_param);
    $("#_qr_code_modal").modal('toggle');
})
$("#_close_qrcode_btn").on('click', function(){
    $("#_qr_code_modal").modal('hide')
})
if(_state == 'account_dashboard'){
    var _logo_img;
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
const _uploatAcctLogoBtn = () => {
    $("#_qr_code_modal").modal('hide')
    $("#_upload_custom_logo_modal").modal('show');
};
$("#_try_again_btn").on('click', () => {
    $("#_input_url_div").removeClass('hide');
    $("#_copy_url_div").addClass('hide').removeClass('show');
    $("#_shortened_url").val("");
    $("#_input_url").val("");
	$("#_shorten_url_btn").text('Shorten').removeAttr('disabled', 'disabled');
});

$("#_acct_upload_img_form").on('submit', function(e){
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
                $("#_dl_btn_div").html('<button type="button" onclick="downloadAccountQr(\''+res.data.attribute.image+'\',\''+res.data.attribute.url_param+'\')" class="btn btn-md rounded btn-light"><i class="uil uil-download-alt"></i> Download</button>');
                $("#_qr_code_modal").modal('toggle');
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
$("#_close_upload_logo_btn").on('click', function() {
    $("#_logo_thumbnail").html('');
    $("#_upload_custom_logo_modal").modal('hide')
    $("#_qr_code_modal").modal('toggle')
})
$("#_new_url_btn").on('click', function(){
    $("#_new_url_modal").modal('toggle')
})
$("#_new_short_url_form").on('submit', function(e) {
    e.preventDefault();
	const long_url = $("#_redirect_url").val();
    
    if (!long_url || long_url == '' || long_url === null){
        Swal.fire({
            icon: 'warning',
            title: 'Error!',
           html: "URL is required! Try again!",
        });   
        return false;
    }
    let formData = new FormData(this);
	$("#_create_new_url_btn").text('Creating...').attr('disabled', 'disabled');
	$.ajax({
		url: base_url+'api/v1/shortener/_new_url',
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
            getURLs();
            $("#_redirect_url").val('');
            $("#_custom_link").val('');
            $("#_custom_title").val('');
	        $("#_create_new_url_btn").text('Create').removeAttr('disabled', 'disabled');
            $("#_new_url_modal").modal('hide')
		}
		else{
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	html: res.data.message,
			});
	        $("#_create_new_url_btn").text('Create').removeAttr('disabled', 'disabled');
		}
		_csrfNonce();
	})
    .fail(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: "Something went wrong! Please refresh the page and Try again!",
      });
      $("#_create_new_url_btn").text('Create').removeAttr('disabled', 'disabled');
		_csrfNonce();
    })
})

function editCustomURL(url_param){
    $("#loader").removeAttr('hidden','hidden');
    let params = new URLSearchParams({'url_param':url_param});
	fetch(base_url+'api/v1/shortener/_get_url_data_v2?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
        $("#_custom_edit_title").val(res.data.title);
        $("#_edit_redirect_url").val(res.data.redirect_url);
        $("#_custom_edit_link").val(url_param);
        $("#_url_param_edit").val(url_param);
        $("#_edit_url_modal").modal('toggle');
        $("#loader").attr('hidden','hidden')
	})
	.catch((error) => {
		console.error('Error:', error);
	});
  

}
$("#_edit_short_url_form").on('submit', function(e) {
    e.preventDefault();
	const long_url = $("#_edit_redirect_url").val();
    
    if (!long_url || long_url == '' || long_url === null){
        Swal.fire({
            icon: 'warning',
            title: 'Error!',
           html: "URL is required! Try again!",
        });   
        return false;
    }
    let formData = new FormData(this);
	$("#_save_url_btn").text('Saving...').attr('disabled', 'disabled');
	$.ajax({
		url: base_url+'api/v1/shortener/_save_custom_url',
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
               html: "Custom URL is sucessfully updated!",
            });
            param = $("#_custom_edit_link").val();
            _getURLData(param);
            $("#_edit_redirect_url").val('');
            $("#_custom_edit_link").val('');
            $("#_custom_edit_title").val('');
	        $("#_save_url_btn").text('Save').removeAttr('disabled', 'disabled');
            $("#_edit_url_modal").modal('hide')
		}
		else{
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	html: res.data.message,
			});
	        $("#_save_url_btn").text('Save').removeAttr('disabled', 'disabled');
		}
		_csrfNonce();
	})
    .fail(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: "Something went wrong! Please refresh the page and Try again!",
      });
      $("#_save_url_btn").text('Save').removeAttr('disabled', 'disabled');
		_csrfNonce();
    })
})
$("#show_secret").on('click', function(){
    $("#secret_key").attr('type','text');
    $(this).attr('hidden','hidden');
    $("#hide_secret").removeAttr('hidden','hidden');
})
$("#hide_secret").on('click', function(){
    $("#secret_key").attr('type','password');
    $(this).attr('hidden','hidden');
    $("#show_secret").removeAttr('hidden','hidden');
})
$("#_update_email_form").on('submit', function(e) {
    e.preventDefault();
	const _email_address = $("#_email_address").val();
    
    if (!_email_address || _email_address == '' || _email_address === null){
        Swal.fire({
            icon: 'warning',
            title: 'Error!',
           html: "Email Address is required! Try again!",
        });   
        return false;
    }
    let formData = new FormData(this);
	$("#_save_email_btn").text('Saving...').attr('disabled', 'disabled');
	$.ajax({
		url: base_url+'api/v1/shortener/_save_email_address',
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
				html:  res.data.message,
				allowOutsideClick: false,
				confirmButtonText: "Refresh Page!"
			}).then((result) => {
			  	if (result.isConfirmed) {
			  		window.location.href = res.data.url;
			  	} 
			})
		}
        else if(Object.values(res.data.message)[0]){
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	html: Object.values(res.data.message)[0],
			});
		}
	    $("#_save_email_btn").text('Save').removeAttr('disabled', 'disabled');
		_csrfNonce();
	})
    .fail(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: "Something went wrong! Please refresh the page and Try again!",
      });
      $("#_save_email_btn").text('Save').removeAttr('disabled', 'disabled');
		_csrfNonce();
    })
})
