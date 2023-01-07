        <!-- Container -->
        <div id="_web_container" class="body-container">
            <div class=" other-section padding-bottom-30 c-dwhite"  >
                <div class="container">
                    <div class="row mt-sm-2 mb-3">
                        <div class="col-lg-12">
                            <div class="card card-services-highlights pt-2  padding-right-30 padding-left-30">
                                <div class="d-flex justify-content-center text-center">
                                    <h1 class="mt-4 f-h1 font-35">URL Shortener & Free Link Customization</h1>
                                </div>
                                <form id="_url_shortener_form">
                                    <div class="row d-flex justify-content-center">

                                        <div class="text-center mt-2">
                                             <p class="p-text">Shortly is a FREE Link Management Platform with Premium Features without account registration.</p>
                                        </div>

                                        <div class="col-lg-8 mt-4 pb-3" id="_url_div">
                                            <div class=" mb-3" id="_input_url_div">
                                                <input type="text" name="long_url" class="input-url form-control" id="_input_url"  placeholder="Enter your URL with http:// or https://">
                                                <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                                <div class="d-grid mt-1">
                                                    <button type="submit" id="_shorten_url_btn" class="btn btn-success rounded br-5 btn-lg mt-2 btn-block btn-shortener">Shorten URL</button>
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

                            <div class="mt-5 text-center">
                                <h2 class="f-h2">Why Use Shortly?</h2>
                                <p class="p-text">Shortly helps online businesses by transforming their website links into powerful tools and create<br> statistics that will provide insights into the business.</p>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-4 text-center mt-2">
                                    <div class="avatar-md m-auto">
                                        <span class="avatar-title bg-success-lighten rounded-circle">
                                            <i class="uil uil-pricetag-alt text-success font-28"></i>
                                        </span>
                                    </div>
                                    <div class="c-gray">
                                        <h4>Free Tools</h4>
                                        <p>Unlike other URL shortener, Shortly a FREE tool that has almost all features of a Link Management platform has.</p>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 text-center mt-2">
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
                                <div class="col-lg-4 text-center mt-2">
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
                                <div class="col-lg-4 text-center mt-2">
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

                                <div class="col-lg-4 text-center mt-2">
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
                </div>
            </div>
        </div>



        <!-- End Container -->