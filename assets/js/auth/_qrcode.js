var _logo_img;
const generateQrCode = (param, image) => {
    $("#generated_qrcode").html('');

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
        data: param,
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
    qrCode.append(document.getElementById("generated_qrcode"));
}
const downloadQr = (image) => {
    param_data = $("#text").val();

    if(param_data == ''){
        param_data = 'Shortly QR Code Generator';
    }
    
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
        data: param,
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
    qrCode.download({ name: "shortly_", extension: "png" });
};
const _upload_logo_btn = () => {
    $("#_upload_custom_logo_modal").modal('show')
};

$("#_close_upload_logo_btn").on('click', function() {
    $("#_logo_thumbnail").html('');
    $("#_upload_custom_logo_modal").modal('hide')
    $("#_qr_code_modal").modal('toggle')
})
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
if(_state == 'qr_code'){
    image = '';
    param = 'Shortly QR Code generator - '+base_url+'qr-code-generator';
    generateQrCode(param, image);

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
$("#_download_qr").on('click', () => {
    image = '';
    downloadQr(image);
})
$("#_close_btn").on('click', () => {
    $("#_upload_custom_logo_modal").modal('hide');
})
$("#_generate").on('click', function(){

    image = '';
    param = $("#text").val();
    if(param == ''){
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            html: "Enter your any Text or URL in the required field!",
      });
      return false;
    }
    generateQrCode(param, image);
})
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