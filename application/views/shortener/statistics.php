        <?php if (!isset($this->session->reg_acct) || isset($this->session->admin)) { ?>
            <!-- Container -->
            <div id="_web_container" class="">
            <div class=" other-section padding-bottom-30 c-dwhite"  >
                <div class="container">
                    <?php if ($this->agent->is_mobile() && $url_data['status'] == 'disabled'){?>
                    <div class="alert alert-danger br-10 mobile-view inline-block-view mt-3" role="alert">
                        <i class="uil-times-circle"></i>This URL has been <b>Disabled</b> for violating our Terms! If you think this was made by mistake <a href="<?=base_url('#contact_us')?>">contact us</a>!
                    </div>
                    <?php } else if ($this->agent->is_mobile() && $blocked_status > 0){?>
                    <div class="alert alert-danger br-10 mobile-view inline-block-view mt-3" role="alert">
                        <i class="uil-times-circle"></i>This URL has been <b>Disabled</b> for violating our Terms! If you think this was made by mistake <a href="<?=base_url('#contact_us')?>">contact us</a>!
                    </div>
                    <?php } ?>
                    <div class="row mt-sm-2 mb-3">
                        <div class="col-lg-4 mt-2">
                            <div class=" display-flex-inline mobile-view">
                                <button class="btn btn-success rounded-alt mobile-view mr-1" type="button" id="_mb_create_account_btn">Create Account</button>
                                <?php if($ad_data['type'] == 'button') { ?>
                                <div class="dropdown button-ad mobile-view"> 
                                    <a style="background-color: #<?=$ad_data['button_color'];?>;" class="btn c-white rounded-alt dropdown-toggle" data-bs-toggle="dropdown" href="<?=base_url('redirect/partner/').$ad_data['ad_id']?>" id="">
                                    <?=$ad_data['button_text']; ?>
                                    </a>
                                    <div class="dropdown-menu dropdown-ad-wrapper">
                                        <a href="<?=base_url('redirect/partner/').$ad_data['ad_id']?>" target="_blank" rel="noopener nofollow" class="c-gray">
                                            <span class="float-end font-10">Sponsored</span>
                                            <div class="ad-logo mt-2 mb-1">
                                                <img src="<?=$ad_data['logo']; ?>" alt="logo" width="50%">
                                            </div>
                                            <div class="ad-details mb-2">
                                                <div class="btn-ad-wording">
                                                <?=$ad_data['description']; ?>
                                                </div>
                                                <a href="<?=base_url('redirect/partner/').$ad_data['ad_id']?>" class="mt-2" target="_blank" rel="noopener nofollow">Learn More</a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php }?>
                            </div>

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
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-8">
                            
                            <?php if (!$this->agent->is_mobile && $url_data['status'] == 'disabled'){?>
                            <div class="alert alert-danger br-10 " role="alert">
                                <i class="uil-times-circle"></i>This URL has been <b>Disabled</b> for violating our Terms! If you think this was made by mistake <a href="<?=base_url('#contact_us')?>">contact us</a>!
                            </div>
                            <?php } else if (!$this->agent->is_mobile && $blocked_status > 0){?>
                            <div class="alert alert-danger br-10 " role="alert">
                                <i class="uil-times-circle"></i>This URL has been <b>Blocked</b> for violating our Terms! If you think this was made by mistake <a href="<?=base_url('#contact_us')?>">contact us</a>!
                            </div>
                            <?php } ?>
                            
                            <div class="row">
                                <div class="col-lg-6 mt-2 web-view">
                                    <button class="btn btn-success rounded-alt mr-1" type="button" id="_create_account_btn">Create Account</button>
                                    <?php if($ad_data['type'] == 'button') { ?>
                                    <div class="dropdown button-ad"> <!-- start ad button -->
                                        <a style="background-color: #<?=$ad_data['button_color'];?>;"  class="btn c-white rounded-alt dropdown-toggle" data-bs-toggle="dropdown" href="<?=base_url('redirect/partner/').$ad_data['ad_id']?>" id="">
                                        <?=$ad_data['button_text']; ?>
                                        </a>
                                        <div class="dropdown-menu  dropdown-ad-wrapper">
                                            <a href="<?=base_url('redirect/partner/').$ad_data['ad_id']?>" target="_blank" rel="noopener nofollow" class="c-gray">
                                                <span class="float-end font-10">Sponsored</span>
                                                <div class="ad-logo mt-2 mb-1">
                                                    <img src="<?=$ad_data['logo']; ?>" alt="<?=$ad_data['name']; ?>" width="50%">
                                                </div>
                                                <div class="ad-details mb-2">
                                                    <?=$ad_data['description']; ?>
                                                    </div>
                                                    <a href="<?=base_url('redirect/partner/').$ad_data['ad_id']?>" class="mt-2" target="_blank" rel="noopener nofollow">Learn More</a>
                                                </div>
                                            </a>
                                        </div>
                                    </div> <!-- end ad button -->
                                    <?php }?>
                                </div>
                                <div class="col-lg-6 mt-2 float-end">
                                    <div for="_select_date" class="d-flex align-items-center mb-2">
                                        <input value="<?=date('m/d/Y', strtotime('-7 days', strtotime($url_data['created_at'])))?> - <?=date('m/t/Y')?>" type="text" class="form-control date me-2 " id="_select_date" data-toggle="date-picker" data-cancel-class="btn-light">
                                        <button class="btn btn-success c-white btn-md rounded-alt" id="_sort_by_date">Sort</button>
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
                                    
                                    <h4 class="card-title mb-3" id="_engagement_overview_title"><span class="placeholder-glow"><span class="placeholder col-4"></span></span></h4>
                                    <div dir="ltr">
                                        <canvas id="_clicks_overview" class="apex-charts mt-3"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-services-highlights pt-1 pb-2 c-gray">
                                <div class="card-body">
                                    <h4 class="card-title mb-3" id="_location_title"><span class="placeholder-glow"><span class="placeholder col-4"></span></span></h4> 
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row" id="_location_chart">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-lg-6">
                                                <!-- <div class="mt-2  text-start font-13" id="loc_count"></div> -->
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-2 float-end font-13" id="loc_pagination"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="card card-services-highlights pt-1 pb-2 c-gray">
                                <div class="card-body">
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
        <div class="modal fade margin-top-10" id="_create_account_modal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1"  aria-labelledby="_add_user_modal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content br-10">
                    <div class="modal-body">
                        <div class="container-fluid">   
                            <h3 class="text-left text-capitalize margin-top-20 fw-300"> <i class="uil uil-user-plus"></i> Create Account</h3>
                                                
                            <form id="_registration_form" class="mb-3">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <p class="font-14">Manage your multiple short URLs in an account. <br>You only need your <b>Secret Key</b> when you log in. 
                                            Keep it safe, make a copy of it and avoid sharing it to anyone you didn't trust!
                                        </p>
                                        <div>
                                            <label for="">Secret Key</label>
                                            <input type="text" class="form-control" value="" id="_secret_key" name="secret_key" required readonly>
                                        </div>
                                        <div class="mt-3">
                                            <label for="">Email Address <small>(Optional)</small></label>
                                            <input type="text" class="form-control" value="" id="_email_address" name="email_address">  
                                            <small>(For recovery purposes only)</small>
                                        </div>
                                        <input type="hidden" name="url_param" value="<?= ($url_param) ? $url_param : ''?>">
                                        <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                        <div class="text-end mt-2">
                                            <button class="btn btn-md btn-success rounded" id="_register_btn" type="submit">Create</button>
                                            <button class="btn btn-md btn-secondary rounded" id="_close_register_btn" type="button">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    <?php } else if (isset($this->session->reg_acct) && isset($this->session->admin) ){?>
        <div id="_web_container" class="">
            <div class=" other-section padding-bottom-30 c-dwhite"  >
                <div class="container">
                    <div class="row mt-sm-2 mb-3">
        
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    