        
						<div id="loader" class="loader-div" hidden>
							<div class="loader-wrapper">
								<img src="<?=base_url('assets/images/other/loader.gif')?>" width="120" heigth="120">
							</div>
						</div>
						<div id="_account_backdrop"></div>
						<!-- Footer Start -->
						<footer class="footer">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-6">
									<?=date('Y')?> &copy; <?=$siteSetting['website_name']?>   
								</div>
								<div class="col-md-6">
									<div class="footer-links d-none d-md-block footer-link-by">
										Developed by: <a href="<?=$siteSetting['developer_site']?>"><?=$siteSetting['developer']?></a>
									</div>
								</div>
							</div>
							</div>
						</footer>
					<!-- end Footer -->
					</div> 
				<!-- content-page -->
				</div> 
			<!-- end page-->
			</div>

			<script src="<?=base_url('assets/js/jquery-3.6.3.min.js')?>"></script>
			<script src="<?=base_url()?>assets/js/vendor/daterangepicker.min.js"></script>
			<script src="<?=base_url()?>assets/js/vendor/croppie.js"></script>
			<script src="<?=base_url()?>assets/js/vendor/Chart.bundle.min.js"></script>
			<script src="<?=base_url()?>assets/js/vendor/moment.min.js"></script>
			<script src="<?=base_url()?>assets/js/vendor/daterangepicker.min.js"></script>
			<script src="<?=base_url()?>assets/js/vendor/qr_code_styling.js"></script>
			<script>
				var base_url = "<?=base_url();?>";
				var _state = <?=($state) ? '"'.$state.'"' : ''?>;
			</script>

			<script src="<?=base_url()?>assets/js/_web_package.min.js"></script>
			<script src="<?=base_url()?>assets/js/_access.js?v=<?=filemtime('assets/js/_access.js')?>"></script>
			<script src="<?=base_url()?>assets/js/_webapp.js?v=<?=filemtime('assets/js/_webapp.js')?>"></script>
			<script src="<?=base_url()?>assets/js/sweetalert2.all.min.js"></script>
			<script src="<?=base_url()?>assets/js/auth/_csrf.js?v=<?=filemtime('assets/js/auth/_csrf.js')?>"></script>
			<script src="<?=base_url()?>assets/js/vendor/select2.min.js"></script>
			<script src="<?=base_url()?>assets/js/clipboard.min.js"></script>
			<script src="<?=base_url()?>assets/js/auth/app.js?v=<?=filemtime('assets/js/auth/app.js')?>"></script>
			<script>
				$('.select-date').daterangepicker();
			</script>
			<?php if(isset($_GET['verify']) && $_GET['verify'] == 'email_verified') { ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    html: "Email Verified!",
                });
            </script>
            <?php }?> 
	</body>
</html>