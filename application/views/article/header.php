<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?=($title == 'index') ? $siteSetting['website_name'] .' - URL Shortener, Short URLs & Free Custom Link Shortener' : $title." | ".$siteSetting['website_name'] ?> </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $description; ?>"/>
        <meta name="keywords" content=""/>
        <meta name="theme-color" content="#05cb62" />
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="<?=$siteSetting['website_name']?>">

        <!-- App link -->
        <link rel="apple-touch-icon" href="" crossorigin="anonymous">
        <link rel="shortcut icon" href="<?=base_url('assets/images/logo/favicon.webp');?>">
        <link rel="manifest" href="/manifest.json" crossorigin="use-credentials">
        <link rel="canonical" href="<?=$canonical_url;?>">
        
        <link href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" rel="stylesheet" >
        <link href="<?=base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?=base_url()?>assets/css/mdi.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?=base_url()?>assets/css/styles.css?v=<?=filemtime('assets/css/styles.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/default.css?v=<?=filemtime('assets/css/default.css')?>" rel="stylesheet" type="text/css" />
	<?php if ($state == 'statistics') {?><link href="<?=base_url()?>assets/css/croppie.css?v=<?=filemtime('assets/css/croppie.css')?>" rel="stylesheet" type="text/css" /><?php } ?>
	<?php if ($state == 'article' || $state == 'new_blog') {?><link href="<?=base_url()?>assets/css/blog.css?v=<?=filemtime('assets/css/blog.css')?>" rel="stylesheet" type="text/css" /><?php } ?>


        <meta property="fb:app_id" content="576747789395855" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?=$article_data['title']?>" />
        <meta property="og:description" content="<?=$article_data['description']?>" />
        <meta property="og:url" content="<?=$canonical_url;?>" />
        <meta property="og:site_name" content="<?=$siteSetting['website_name']?>" />
        <meta property="og:image" content="<?=$article_data['article_image']?>" />
        <meta property="og:image:width" content="580" />
        <meta property="og:image:height" content="580" />
        <meta property="og:image:alt" content="" />

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="<?=base_url()?>">
        <meta name="twitter:creator" content="atShortly">
        <meta name="twitter:title" content="<?=$article_data['title']?>">
        <meta name="twitter:image" content="<?=$article_data['article_image']?>">
        <script async src="https://cdn.ampproject.org/v0.js"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-TREBS548CZ"></script>
        <!-- <?=($state=='statistics')?'<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9264139322313019" crossorigin="anonymous"></script>' : ''?> -->
        
    </head>

    <body class="" >
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "NewsArticle",
          "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?=$canonical_url;?>"
          },
          "headline": "<?=$article_data['title']?>",
          "image": "<?=$article_data['article_image']?>",
          "datePublished": "<?=$article_data['created_at']?>",
          "dateModified": "<?=$article_data['updated_at']?>:",
          "author": {
            "@type": "Person",
            "name": "Staff"
          },
           "publisher": {
            "@type": "Organization",
            "name": "<?=$siteSetting['website_name']?>",
            "logo": {
              "@type": "ImageObject",
              "url": "<?=base_url('assets/images/logo/logo.png')?>"
            }
          },
          "description": "<?=$article_data['description']?>"
        }
   </script>
   <script type='application/ld+json'>
        {
        "@context":"https://schema.org",
        "@type":"BreadcrumbList",
        "itemListElement":[{
          "@type":"ListItem",
          "position":1,
          "item":
            {
              "@id":"<?=base_url()?>",
              "name":"Home"
            }
          },
            {
              "@type":"ListItem",
              "position":2,
              "item":{
                "@id":"<?=base_url('blog')?>",
                "name":"Blog"
              }
            },
            {
              "@type":"ListItem",
              "position":3,
              "item":{
                "@id":"<?=base_url('category/').strtolower($article_data['category'])?>",
                "name":"<?=$article_data['category']?>"
              }
            },
            {
              "@type":"ListItem",
              "position":4,
              "item":{
                "@id":"<?=$article_data['url']?>",
                "name":"<?=$article_data['title']?>"
              }
            }
          ]
        }
    </script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?=$siteSetting['ga_tag']?>');
    </script>
    <div class="position-relative">
		<div class="custom-alert-box" id="_custom_alert" hidden="hidden"></div>	
	</div>
    <!-- Begin page -->