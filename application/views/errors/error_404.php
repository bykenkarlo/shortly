<!DOCTYPE html>
<html lang="en">
<head>
<title>404 Page Not Found</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="ERROR 404.">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#000" />

<link rel="shortcut icon" href="<?=base_url()?>assets/images/logo/favicon.webp">
<link href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" rel="stylesheet" >
<link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
<link href="<?=base_url()?>assets/css/default.css" rel="stylesheet" type="text/css" id="light-style" />
<link href="<?=base_url()?>assets/css/styles.css" rel="stylesheet" type="text/css" id="light-style" />

<style type="text/css">
* {
  font-family: 'Plus Jakarta Sans', sans-serif;
}
p {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 16px;
  line-height: 1.8;
  font-weight: 400;
  color: #383838;
  -webkit-font-smoothing: antialiased;
  -webkit-text-shadow: rgba(0,0,0,.01) 0 0 1px;
  text-shadow: rgba(0,0,0,.01) 0 0 1px;
}
h1, h2 , h3 {
  font-family: 'Plus Jakarta Sans', sans-serif;
}
.footer-below{
    bottom: 0;
    right: 0;
}
.content {
    font-size: 16px;
    color: #383838;
}
.image_404 {
  display: block;
  width: 330px;
  height: 330px;
  -moz-border-radius: 100%;
  -webkit-border-radius: 100%;
  object-fit: cover;
  background-repeat: no-repeat;
  margin-left: auto;
  margin-right: auto;
}
</style>
</head>
<body class="body-bg-error">
    <div class="super_container">
        <div class="">
            <div class="content mt-2 mb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mt-3">

                            <h1 class="mt-2 justify-content-center font-35">Sometimes when you close your eyes... you can't see.</h1>

                            <img src="<?=base_url('assets/images/cannot-see.webp')?>" class="image_404" height="180" alt="404 page">

                            <h2 class=" font-27 fw-600 mt-4">This is a 404 Page!</h4>
                            <p class="p-text mt-3 font-15">It's looking like you may have taken a wrong turn. Don't worry... it
                                happens to the best of us. Here's a little tip that might help you get back on track.</p>

                            <a class="btn mt-2 btn-dark btn-lg font-18 c-white rounded" href="<?=base_url();?>"><i class="uil-back"></i> Go Home</a>
                        </div> 
                    </div> 
                </div>
            </div> 
       </div> 
