<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Redirecting URL ... / Shortly</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="FREE URL Shortener, Link management software, QR Code feature"/>
        <meta name="theme-color" content="#05cb62" />

        <!-- App link -->
        <link rel="shortcut icon" href="<?=base_url('assets/images/logo/favicon.webp');?>">
        <link rel="canonical" href="<?=$url;?>">
        <link href="<?=base_url()?>assets/css/default.css?v=<?=filemtime('assets/css/default.css')?>" rel="stylesheet" type="text/css" />
	    <script src="<?=base_url('assets/js/jquery-3.6.3.min.js')?>"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-TREBS548CZ"></script>
        <style>
            
            .font-10{
                font-size: .7rem;
            }
            .img-fluid {
                max-width: 98%;
                height: auto;
            }
            .text-center{
                text-align: center;
            }
            .note-div{
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                background-color: #1d212d;
                color: #cbd5e0;
                text-align: center;
                padding: 10px;

            }
            .note{
                padding: 20px;
            }
        </style>
    </head>

    <body>
        <div id="loader" class="loader-div" hidden>
            <div class="redirect-banner">
                <a href="https://shortly.at/coinomize" target="_blank" rel="noopener">
                    <img src="<?=base_url('assets/images/other/')."banner-1001.jpg"?>" class="img-fluid" alt="banner ad">
                </a>
                <div class="c-light font-10 mt-1">Advertisement</div>
                
            </div>
			<div class="loader-wrapper">
				<img src="<?=base_url('assets/images/other/loader.gif')?>" width="120" heigth="120">
			</div>

            <div class="text-center note-div">
                <small class="note">If you think the redirected URL is a Phishing URL, malware or a spam. Kindly report it to <a href="mailto:info@shortly.at">info@shortly.at</a></small>
            </div>
		</div>
        <script>
            $("#loader").removeAttr('hidden','hidden');
            setTimeout(function(){
                window.location.href="<?=$url;?>"
            }, 2000);
        </script>
    </body>
</html>