<?php echo'<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"> 
    <url>
        <loc><?= base_url();?></loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= base_url('about');?></loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= base_url('privacy-terms');?></loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= base_url('blog');?></loc>
        <priority>1.0</priority>
    </url>
    <?php foreach($articles as $a) { ?>
    <url>
        <loc><?= base_url('article/').$a['url'];?></loc>
        <priority>1.0</priority>
    </url>
    <?php } ?>
    
</urlset>
