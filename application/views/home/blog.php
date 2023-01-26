
	<div id="_web_container">
		<div class="body-container padding-top-30 padding-bottom-30 c-dwhite"  >
			<div class="container m-blog-div">
				<div class="row mt-sm-1 mb-3 blog-wrapper ">
					<div class="col-lg-12 text-secondary">
						<div class="mb-2">
						</div>
						<?php if (!empty($recent_blog_data)){ ?>
						<?php foreach($recent_blog_data as $rcb) { ?>
						<a href="<?=$rcb['url']?>" class="text-secondary">
							<div class="row">
								<div class="col-lg-7">
									<img src="<?=$rcb['article_image']?>" class="img-fluid br-10" alt="<?=$rcb['title']?>">
								</div>		
								<div class="col-lg-5 ">
									<h1 class="font-27"><?=$rcb['title']?></h1>
									<p class="text-muted"><?=$rcb['description'].'...'?></p>
									<span class="mt-1 text-muted"><?=$rcb['created_at']?> • <?=$rcb['min_read']?> min read</span>
								</div>
							</div>
						</a>
						<?php } ?>					
						<?php } else { ?>
						<div class="col-lg-12">
						    <div class="card row shadow-none mb-0" aria-hidden="true">
						    	<div class="col-lg-7">
						    		<img src="assets/images/thumbnail.webp" class="card-img-top" alt="...">
						    	</div>
						        <div class="col-lg-5">
						        	<div class="card-body">
							            <h5 class="card-title placeholder-glow">
							                <span class="placeholder col-6"></span>
							            </h5>
							            <p class="card-text placeholder-glow">
							               	<span class="placeholder col-7"></span>
							                <span class="placeholder col-4"></span>
							                <span class="placeholder col-4"></span>
							                <span class="placeholder col-6"></span>
							                <span class="placeholder col-8"></span>
							   	        </p>
							        </div> 
						        </div>
						    </div> 
						</div> 

						<?php } ?>					
						<div class="row mt-5">
							<?php if (!empty($blog_data)){ ?>
							<?php foreach($blog_data as $q){ ?>
							<div class="col-lg-3 mb-4">
								<a href="<?=$q['url']?>" class="text-secondary">
									<div class="">
										<img src="<?=$q['article_image']?>" class="img-fluid br-10" alt="<?=$q['title']?>">
										<h2 class="font-17 fw-600" ><?=$q['title']?></h2>
										<span class="text-muted font-15"><?=$q['created_at']?>  • <?=$q['min_read']?> min read</span>
									</div>
								</a>
							</div>
							<?php } ?>
							<?php } else { ?>
							<div class="col-md-3">
						        <div class="card shadow mb-0" aria-hidden="true">
						            <img src="assets/images/thumbnail.webp" class="card-img-top" alt="...">
						            <div class="card-body">
						                <h5 class="card-title placeholder-glow">
						                    <span class="placeholder col-6"></span>
						                </h5>
						                <p class="card-text placeholder-glow">
						                    <span class="placeholder col-7"></span>
						                    <span class="placeholder col-4"></span>
						                    <span class="placeholder col-4"></span>
						                    <span class="placeholder col-6"></span>
						                    <span class="placeholder col-8"></span>
						                </p>
						            </div> 
						        </div> 
						    </div> 

						    <div class="col-md-3">
						        <div class="card shadow mb-0" aria-hidden="true">
						            <img src="assets/images/thumbnail.webp" class="card-img-top" alt="...">
						            <div class="card-body">
						                <h5 class="card-title placeholder-glow">
						                    <span class="placeholder col-6"></span>
						                </h5>
						                <p class="card-text placeholder-glow">
						                    <span class="placeholder col-7"></span>
						                    <span class="placeholder col-4"></span>
						                    <span class="placeholder col-4"></span>
						                    <span class="placeholder col-6"></span>
						                    <span class="placeholder col-8"></span>
						                </p>
						            </div> 
						        </div> 
						    </div> 

						    <div class="col-md-3">
						        <div class="card shadow mb-0" aria-hidden="true">
						            <img src="assets/images/thumbnail.webp" class="card-img-top" alt="...">
						            <div class="card-body">
						                <h5 class="card-title placeholder-glow">
						                    <span class="placeholder col-6"></span>
						                </h5>
						                <p class="card-text placeholder-glow">
						                    <span class="placeholder col-7"></span>
						                    <span class="placeholder col-4"></span>
						                    <span class="placeholder col-4"></span>
						                    <span class="placeholder col-6"></span>
						                    <span class="placeholder col-8"></span>
						                </p>
						            </div> 
						        </div> 
						    </div> 

						    <div class="col-md-3">
						        <div class="card shadow mb-0" aria-hidden="true">
						            <img src="assets/images/thumbnail.webp" class="card-img-top" alt="...">
						            <div class="card-body">
						                <h5 class="card-title placeholder-glow">
						                    <span class="placeholder col-6"></span>
						                </h5>
						                <p class="card-text placeholder-glow">
						                    <span class="placeholder col-7"></span>
						                    <span class="placeholder col-4"></span>
						                    <span class="placeholder col-4"></span>
						                    <span class="placeholder col-6"></span>
						                    <span class="placeholder col-8"></span>
						                </p>
						            </div> 
						        </div> 
						    </div> 

							
							<?php } ?>
						</div>
	            </div>
			</div>
		</div>
	</div>
