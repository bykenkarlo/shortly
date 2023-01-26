        
		<div class="" id="_menu_backdrop"></div>
		
		<div id="loader" class="loader-div" hidden>
            <div class="loader-wrapper">
                <img src="<?=base_url('assets/images/other/loader.gif')?>" width="120" heigth="120">
            </div>
        </div>

		<div class="footer-div padding-bottom-30 pt-5">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="cursor-pointer">
		                	<img src="<?=base_url('assets/images/logo/hh-logo-light.webp')?>" alt="<?=$siteSetting['website_name']?> " class="logo-dark hh-logo" height="59" />
		            	</div>
					</div>

					<div class="col-lg-6">
			            <ul class="no-list-style-inline ml-n-3 mt-2 font-20 footer-social-icon">
			            <?php foreach($social_media as $sm) { ?>
			            	<?php if ($sm['social_media'] == 'facebook') { ?>
			  				<li><a href="<?=$sm['handle']?>" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-facebook-f c-white"></i></a></li><?php } ?>
			  				<?php if ($sm['social_media'] == 'twitter') { ?>
			            	<li><a href="<?=$sm['handle']?>" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-twitter c-white"></i></a></li><?php } ?>
			            	<?php if ($sm['social_media'] == 'instagram') { ?>
			           		<li><a href="<?=$sm['handle']?>" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-instagram c-white"></i></a></li><?php } ?>
			           		<?php if ($sm['social_media'] == 'tiktok') { ?>
			           		<li><a href="<?=$sm['handle']?>" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-tiktok c-white"></i></a></li><?php } ?>
							<?php if ($sm['social_media'] == 'github') { ?>
			           		<li><a href="<?=$sm['handle']?>" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-github c-white"></i></a></li><?php } ?>
							<?php if ($sm['social_media'] == 'linkedin') { ?>
			           		<li><a href="<?=$sm['handle']?>" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-linkedin-in c-white"></i></a></li><?php } } ?>
						</ul>
					</div>
					
					<div class="col-lg-6">
		            	<p class="font-14 fw-400 mt-2 footer-title"><?=$siteSetting['description']?></p>
		            	<!-- <div class="mt-3">
		            		<h4 class="font-16 footer-title">Office Details</h4>
			            	<ul class="no-list-style ml-n-3 footer-text">
							</ul>
		            	</div> -->
					</div>
					<div class="col-lg-3">
						<!-- <h3 class="font-16 footer-title">Website</h3> -->
						<ul class="no-list-style ml-n-3 footer-text">
							<li><a class="cursor-pointer" onclick="_accessPage('about')">About Us</a></li>
							<li><a class="cursor-pointer" onclick="_accessPage('privacy-terms')">Terms of Use</a></li>
						</ul>
					</div>	

					<div class="col-lg-3">
						<!-- <h3 class="font-16 footer-title">Products</h3> -->
						<ul class="no-list-style ml-n-3 footer-text">
							<li><a class="cursor-pointer" onclick="_accessPage('')">Link Shortener</a></li>
							<li><a class="cursor-pointer" onclick="_accessPage('qr-code-generator')">QR Code Generator</a></li>
						</ul>
					</div>	

				</div>
				<div class="mt-3 text-center footer-text font-13 ">
					&copy; <?=date('Y')?>. <?=$siteSetting['website_name']?> All rights reserved.
				</div>
			</div>
		</div>
		<!-- bundle -->

		<!-- <div id="_tos_privacy_consent" hidden="hidden">
		    This website uses cookies. By continuing to use this website you are giving consent to cookies being used. Visit our <a target="_blank" class="text-kwartz" rel="noopener" href="<?=base_url('terms')?>">Terms and Conditions</a> and <a target="_blank" rel="noopener" class="text-kwartz" href="<?=base_url('privacy')?>">Privacy Policy</a>. <button class="btn btn-kwartz c-white btn-agree-tos-privacy rounded" id="_agreed_tos_privacy">I Agree</button>
		</div> -->


		<script>
			var base_url = "<?=base_url();?>";
			var _state = <?=($state) ? '"'.$state.'"' : ''?>;
			<?= ($url_param !== '') ? "var _url_param = '".$url_param."';" : ''?>
			<?= ($state=='blog_category')?"var _category = '".$category."';" : ''?>				
			<?= ($state=='blog_tags')?"var _tags = '".$tags."';" : ''?>				
		</script>
	    <script src="<?=base_url('assets/js/jquery-3.6.3.min.js')?>"></script>
		<script src="<?=base_url()?>assets/js/_web_package.min.js"></script>
		<script src="<?=base_url()?>assets/js/_webapp.js?v=<?=filemtime('assets/js/_webapp.js')?>"></script>
		<script src="<?=base_url()?>assets/js/_access.js?v=<?=filemtime('assets/js/_access.js')?>"></script>
		<script src="<?=base_url()?>assets/js/auth/_article.js?v=<?=filemtime('assets/js/auth/_article.js')?>"></script>
		<?=($state=='blog_category' || $state =='blog_tags')?'<script src="'.base_url().'assets/js/auth/_blog_category.js?v=<?='.filemtime('assets/js/auth/_blog_category.js').'?>"></script>':''?>
	</body>
</html>