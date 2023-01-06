        <!-- Container -->
        <div id="_web_container" class="">
            <div class=" other-section padding-bottom-30 c-dwhite"  >
                <div class="container">
                    <div class="row mt-sm-2 mb-3">
                        <div class="col-lg-12">
                            <div class="card card-services-highlights pt-2 pb-2 padding-right-30 padding-left-30">
                                <div class="d-flex justify-content-center text-center">
                                    <h1 class="mt-3 mb-4 f-h1">URL Shortener & Free Link Customization</h1>
                                </div>
                                <form id="_url_shortener_form">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-lg-8" id="_url_div">
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

                                            <div class="text-center mt-4">
                                                <p class="p-text">Shortly is a FREE URL Shortener Tool with Premium Features without account registration.</p>
                                                <p class="p-text">Use our URL Shortener to create a shortened link making it easy to remember for your products.</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>



        <!-- End Container -->