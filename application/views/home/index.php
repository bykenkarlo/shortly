        <!-- Container -->
        <div id="_web_container" class="body-container">
            <div class="fo-section other-section padding-bottom-50 c-dwhite first-section"  >
                <div class="container">
                    <div class=" mb-3 ">
                        <div class=" pt-5 padding-right-30 padding-left-30  mt-3 mb-2">
                            <div class="d-flex justify-content-center text-center">
                                <h1 class="mt-4 f-h1 font-35 c-white">URL Shortener & Free Link Customization</h1>
                            </div>
                            <form id="_url_shortener_form">
                                <div class="row d-flex justify-content-center">
                                    <div class="text-center mt-2">
                                         <p class="p-text c-white">Shortly is a FREE Link Management Platform with Premium Features without account registration.</p>
                                    </div>

                                    <div class="col-lg-8 mt-2 pb-3" id="_url_div">
                                        <div class=" mb-3" id="_input_url_div">
                                            <input type="text" name="long_url" class="input-url form-control" id="_input_url"  placeholder="Enter your URL" autofocus>
                                            <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                            <div class="d-grid mt-1">
                                                <button type="submit" id="_shorten_url_btn" class="btn btn-success rounded br-5 btn-lg mt-2 btn-block btn-shortener">Shorten</button>
                                            </div>
                                        </div>
                                        <div class="hide mb-3" id="_copy_url_div" >
                                            <input type="text" name="shortened_url" class="input-url form-control" id="_shortened_url" placeholder="Your Shortened URL" readonly>
                                            <div class="text-end m-1">
                                                <button type="button" id="_copy_url_btn" data-clipboard-target="#_shortened_url" class="btn btn-success rounded br-5 btn-lg btn-md mt-1 btn-shortener">Copy</button>
                                                <button type="button" id="_monitor_btn" class="btn btn-primary rounded br-5 btn-lg btn-md mt-1 btn-shortener" >Track URL</button>
                                                <button type="button" id="_try_again_btn" class="btn btn-secondary rounded br-5 btn-lg btn-md mt-1 btn-shortener">Try Again</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="other-section padding-bottom-30 c-dwhite">
                <div class="container">
                    <div class="mt-5 text-center" id="features">
                        <h2 class="f-h2">Why Use Shortly?</h2>
                        <p class="p-text">Shortly is a valuable tool for any business, marketer or internet users looking to optimize their online presence. <br>
                            You can easily track and analyze the performance of your links, and make data-driven decisions to improve your campaigns and drive better results.</p>
                    </div>

                    <div class="row mt-3 mb-4">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 text-center mt-2">
                            <div class="avatar-md m-auto">
                                <span class="avatar-title bg-success-lighten rounded-circle">
                                    <i class="uil uil-pricetag-alt text-success font-28"></i>
                                </span>
                            </div>
                            <div class="c-gray">
                                <h4>Free Tools</h4>
                                <p>Unlike other URL shortener, Shortly is a FREE tool that has almost all premium features of a Link Management platform has.</p>
                            </div>
                        </div>
                                
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 text-center mt-2">
                            <div class="avatar-md m-auto">
                                <span class="avatar-title bg-success-lighten rounded-circle">
                                    <i class="uil uil-chart-line text-success font-28"></i>
                                </span>
                            </div>
                            <div class="c-gray">
                                <h4>Statistics</h4>
                                <p>Provides complete statistics from Browser, Platform, Location, Referrers and etc.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 text-center mt-2">
                             <div class="avatar-md m-auto">
                                <span class="avatar-title bg-success-lighten rounded-circle">
                                    <i class="uil uil-qrcode-scan text-success font-28"></i>
                                </span>
                            </div>
                            <div class="c-gray">
                                <h4>Customized QR Code</h4>
                                <p>Generate a customizable QR code and upload your business' logo image.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 text-center mt-2">
                             <div class="avatar-md m-auto">
                                <span class="avatar-title bg-success-lighten rounded-circle">
                                    <i class="uil uil-files-landscapes-alt text-success font-28"></i>
                                </span>
                            </div>
                            <div class="c-gray">
                                <h4>Multiple Links Management</h4>
                                <p>Manage muiltiple Links in a dashboard with optional registration.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 text-center mt-2">
                            <div class="avatar-md m-auto">
                                <span class="avatar-title bg-success-lighten rounded-circle">
                                    <i class="uil uil-shield-check text-success font-28"></i>
                                </span>
                            </div>
                               <div class="c-gray">
                                <h4>Secured</h4>
                                <p>Fast and secure, Shortly uses HTTPS protocol and data encryption.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 text-center mt-2">
                            <div class="avatar-md m-auto">
                                <span class="avatar-title bg-success-lighten rounded-circle">
                                    <i class="uil uil-apps text-success font-28"></i>
                                </span>
                            </div>
                            <div class="c-gray">
                                <h4>Progressive Web App</h4>
                                <p>A platform that can be used in any device via browser and can be installed as apps too.</p>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>

            <!-- <div class="other-section padding-bottom-70 c-dwhite">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-12">
                            <img class="img-fluid" src="<?=base_url()?>assets/images/other/check-url.webp" alt="checking URL status">
                        </div>
                        <div class="col-lg-5 col-md-6 col-12 mt-2">
                            <h2 class="f-h2">Check URL Statistics</h2>
                            <p class="p-text">
                                Want to know your shortened URL statistics? Check your shortened URL statistics by clicking the button below. 
                            </p>
                            <button id="_check_url_stat_btn" class="btn btn-success rounded btn-lg pr-4 pl-4" type="button">Check</button>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="recommend-section padding-bottom-70 c-dwhite" id="contact_us">
                <div class="container">
                    <div class="text-center">
                        <h2 class="f-h3 mb-2 c-white">Questions? Suggestions? Would love to hear it!</h2>
                        <p class="p-text c-white font-15">We are open for questions and suggestions for any possible features that can be added on the site. Let us know by contacting us using the button below.</p>
                        <button class="btn btn-lg btn-light rounded" type="button" id="_email_us">Email Us</button>
                    </div>
                </div>
            </div>

            <div class="other-section padding-bottom-50 padding-top-50 c-dwhite">
                <div class="container">
                    <div class="text-center">
                        <h2 class="f-h3 mb-2">Stay tune, new features will be released soon.</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="_url_stat_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg " >
                <div class="modal-content br-10">
                    <div class="modal-header ">
                        <h4 class="modal-title " id="myLargeModalLabel"><i class="uil uil-chart-line "></i> Check URL Statistics</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                    
                </div>
                </div>
            </div>
         </div>


        <!-- End Container -->