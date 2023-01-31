        <!-- Container -->
        
        <div id="_web_container" class="">
            <div class=" other-section padding-bottom-30 c-dwhite"  >
                <div class="container">
                    <div class="row mt-sm-2 mb-3">
                        <div class="col-lg-4">
                            <div class="card card-services-highlights pt-1 pb-2  c-gray">
                                <div class="card-body">
                                    <div class="float-end" id="_copy_url_div">
                                    </div>
                                    
                                    <div class="text-left" id="_url_wrap">
                                        <div class="">
                                            <h1 class="mt-1 c-black font-18 pointer-cursor" id="_short_url"><span class="placeholder-glow"><span class="placeholder col-9"></span></span></h1> 
                                        </div>
                                        <div id="_created_div"><span class="placeholder-glow"><span class="placeholder col-5"></span></span></div>
                                    </div>
                                    <div class="mt-1">
                                        <div id="_engagement_div"><span class="placeholder-glow"><span class="placeholder col-7"></span></span></div>
                                    </div>
                                </div>
                            </div> 
                            <div class="card card-services-highlights pb-2 c-gray card_qr_div">
                                <div class="card-body placeholder-glow">
                                    <h4 class="card-title mb-3" id="_qr_code_title"><span class="placeholder col-4"></span></h4>
                                    <div class="text-center" id="_url_wrap">
                                        <div class=" qr_code " id="_qr_code">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-1 ">
                                        <div class="margin-right-10" id="_dl_btn_div">
                                            <button class="btn  col-5"> </button>
                                        </div>
                                        <div class=" margin-right-10" id="_upload_btn_div">
                                            <button class="btn  col-5"> </button>
                                        </div>
                                    </div>
                                    <!-- <div class="mt-2 text-center">
                                        <a href="#more_option" id="_more_opt">+ More Options</a>
                                    </div> -->
                                </div>
                            </div>
                            <!-- <div class="card card-services-highlights pb-2">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center mt-1 ">
                                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9264139322313019" crossorigin="anonymous"></script>
                                    <ins class="adsbygoogle"
                                        style="display:block"
                                        data-ad-client="ca-pub-9264139322313019"
                                        data-ad-slot="6915775442"
                                        data-ad-format="auto"
                                        data-full-width-responsive="true"></ins>
                                    <script>
                                        (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>
                                    <small class="c-gray">Advertisement <i class="uil-question-circle" class="cursor-pointer"></i></small>
                                    </div>
                                </div>
                            </div> -->
                        </div> 
                        <div class="col-lg-8">
                            
                            <?php if ($url_data['status'] == 'disabled'){?>
                            <div class="alert alert-danger br-10" role="alert">
                                <i class="uil-times-circle"></i>This URL has been <b>Disabled</b> for violating our Terms! If you think this was made by mistake <a href="<?=base_url('#contact_us')?>">contact us</a>!
                            </div>
                            <?php } ?>

                            
                            <div class="row">
                                <div class="col-lg-6  mt-2 ">
                                </div>
                                <div class="col-lg-6 mt-2 float-end">
                                    <div for="_select_date" class="d-flex align-items-center mb-2">
                                        <input value="<?=date('m/d/Y', strtotime('-7 days'))?> - <?=date('m/t/Y')?>" type="text" class="form-control date me-2 rounded" id="_select_date" data-toggle="date-picker" data-cancel-class="btn-light">
                                        <button class="btn btn-success c-white btn-md rounded" id="_sort_by_date">Sort</button>
                                     </div>
                                 </div>
                            </div>
                            
                            <div class="card card-services-highlights pb-2  c-gray">
                                <div class="card-body">
                                    <div id="_redirect_title"><span class="placeholder-glow"><span class="placeholder col-4"></span></span></div>
                                    <div id="_redirect_url" class="redirect-link custom-tooltip"><span class="placeholder-glow"><span class="placeholder col-12"></span></span></div>
                                </div>
                            </div>

                            <div class="card card-services-highlights pt-1 pb-2  c-gray">
                                <div class="card-body placeholder-glow">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" onclick="clickStats('<?=$url_param?>','7_days')" href="#clickStats">Last 7 days</a>
                                            <a class="dropdown-item" onclick="clickStats('<?=$url_param?>','30_days')" href="#clickStats">Last 30 days</a>
                                            <a class="dropdown-item" onclick="clickStats('<?=$url_param?>','1_year')" href="#clickStats">1 year</a>
                                        </div>
                                    </div>
                                    
                                    <h4 class="card-title mb-3" id="_engagement_overview_title"><span class="placeholder-glow"><span class="placeholder col-4"></span></span></h4>
                                    <div dir="ltr">
                                        <canvas id="_clicks_overview" class="apex-charts mt-3"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-services-highlights pt-1 pb-2 c-gray">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" onclick="locationStat('<?=$url_param?>','7_days')" href="#locationStat">Last 7 days</a>
                                            <a class="dropdown-item" onclick="locationStat('<?=$url_param?>','30_days')" href="#locationStat">Last 30 days</a>
                                            <a class="dropdown-item" onclick="locationStat('<?=$url_param?>','1_year')" href="#locationStat">1 year</a>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-3" id="_location_title"><span class="placeholder-glow"><span class="placeholder col-4"></span></span></h4> 
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row" id="_location_chart">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="card card-services-highlights pt-1 pb-2 c-gray">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" onclick="_browserPlatformStat('<?=$url_param?>','7_days')" href="#_browserPlatformStat">Last 7 days</a>
                                            <a class="dropdown-item" onclick="_browserPlatformStat('<?=$url_param?>','30_days')" href="#_browserPlatformStat">Last 30 days</a>
                                            <a class="dropdown-item" onclick="_browserPlatformStat('<?=$url_param?>','1_year')" href="#_browserPlatformStat">1 year</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 mb-2 mt-2">
                                        <h4 class="card-title mb-3" id="_browser_title"><span class="placeholder-glow"><span class="placeholder col-4"></span></span></h4>
                                            <div>
                                                <canvas id="_browser_overview" class="apex-charts mt-3"></canvas>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-2 mt-2">
                                        <h4 class="card-title mb-3" id="_platform_title"><span class="placeholder-glow"><span class="placeholder col-4"></span></span></h4>
                                            <div>
                                                <canvas id="_platform_overview" class="apex-charts mt-3"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card card-services-highlights pt-1 pb-2 c-gray">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" onclick="referrerStat('<?=$url_param?>','7_days')" href="#referrerStat">Last 7 days</a>
                                            <a class="dropdown-item" onclick="referrerStat('<?=$url_param?>','30_days')" href="#referrerStat">Last 30 days</a>
                                            <a class="dropdown-item" onclick="referrerStat('<?=$url_param?>','1_year')" href="#referrerStat">1 year</a>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-3" id="_referrer_title"><span class="placeholder-glow"><span class="placeholder col-4"></span></span></h4>
                                    <div class="row">
                                        <div class="col-lg-12 mb-2 mt-2">
                                            <div dir="ltr">
                                                <canvas id="_referrer_overview" class="apex-charts mt-3"></canvas>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div> 

                            <div id="jnt">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade margin-top-10" id="_upload_custom_logo_modal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1"  aria-labelledby="_add_user_modal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content br-10">
                    <div class="modal-body">
                        <div class="container-fluid">   
                            <h3 class="text-left text-capitalize margin-top-20 fw-300"> <i class="uil uil-upload-alt"></i> Upload Logo</h3>
                            <div class="mb-2">
                                <img alt="Logo image" src="<?=base_url('assets/images/thumbnail.webp')?>" id="_logo_thumbnail" width="220" class="br-10 cursor-pointer" >
                             </div>
                                                
                            <form id="_upload_img_form" class="mb-3">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="custom-file">
                                            <label class="form-label">Your Image</label>
                                            <input onchange="readImageURL(this)" class="form-control" name="logo_img" id="_logo_img" type="file" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                    <input type="hidden" name="url_param" value="<?= ($url_param) ? $url_param : ''?>">
                                    <div class="text-end">
                                        <button class="btn btn-md btn-success rounded" id="_upload_btn" type="submit">Upload</button>
                                        <button class="btn btn-md btn-secondary rounded" id="_close_btn" type="button">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>

         <div class="modal fade margin-top-10" id="_edit_url_modal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1"  aria-labelledby="_add_user_modal" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content br-10">
                    <div class="modal-body">
                        <div class="container-fluid">   
                            <h3 class="text-left text-capitalize margin-top-20 fw-300"> <i class="uil uil-edit-alt"></i> Customize Short URL</h3>
                                                
                            <form id="_edit_url_form" class="mb-3">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <p class="alert alert-warning bg-warning-lighten font-14">Changing this URL will result to inaccessible of your previous edited URLs!</p>
                                        <p>
                                            URL: <?=preg_replace("(^https?://)", "", base_url() )?><span id="_url_param_view"></span>
                                        </p>
                                        <input type="text" class="form-control" value="" id="_edit_url_param" name="edit_url_param" required>
                                        <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                        <input type="hidden" id="_url_param" name="url_param" value="<?= ($url_param) ? $url_param : ''?>">
                                        <div class="text-end mt-2">
                                            <button class="btn btn-md btn-success rounded" id="_customize_url_btn" type="submit">Update</button>
                                            <button class="btn btn-md btn-secondary rounded" id="_close_update_url_btn" type="button">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>


        <!-- End Container -->
        