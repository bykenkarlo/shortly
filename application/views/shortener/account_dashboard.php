                <div class="content-page account">
                    <div class="content">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $siteSetting['website_name']; ?></a></li>
                                            <li class="breadcrumb-item active"><?=$title?></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?=$title?></h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-lg-4 mb-2">
                                <div class="d-grid">
                                    <button class="btn btn-success rounded text-center" type="button" id="_new_url_btn">Create New</button>
                                </div>
                             </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6 float-end mb-2">
                                <div for="_select_date" class="d-flex align-items-center mb-2">
                                    <input value="<?=date('m/d/Y', strtotime('-60 days'))?> - <?=date('m/t/Y')?>" id="_select_date" type="text" class="form-control date me-2 select-date" data-toggle="date-picker" data-cancel-class="btn-light">
                                    <button class="btn btn-success c-white btn-md rounded" id="_su_sort_by_date" data-param="">Sort</button>
                                 </div>
                            </div>
                            
                            <div class="col-xl-4 col-lg-4">
                                <div class="card tilebox-one">
                                    <div id="url_list" class="list-group">
                                        
                                    </div> 
                                </div>
                            </div> <!-- end col -->
                            <div class="col-xl-8 col-lg-8 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <button class="arrow-none card-drop cursor-pointer btn rounded btn-light font-14 me-1 fw-500" id="_edit_url_btn">
                                                <i class="uil uil-pen"></i> Edit 
                                            </button>
                                            <!-- <button class="arrow-none card-drop cursor-pointer btn rounded btn-light font-14 me-1 fw-500" id="_edit_url_btn">
                                                <i class="uil uil-trash"></i> Delete 
                                            </button> -->
                                            <span href="#" id="qr_url" data-param="" class="arrow-none card-drop cursor-pointer" aria-expanded="false">
                                                <i class="uil uil-qrcode-scan"></i>
                                            </span>
                                            <input type="hidden" id="_img_logo">
                                        </div>

                                        <div class="short-summary">
                                            <div class="su-title">
                                                <h1 class="card-title mb-3 font-20 fw-700" id="_su_title">Title Here</h1>    
                                            </div>
                                            <div id="_created_div" class="mt--10">
                                                <i class="uil uil-calendar-alt"></i> <span id="_su_created_at" class="font-14">Created Date</span>
                                            </div>
                                            <div id="_engagement_div">
                                                <i class="uil uil-chart-bar font-13" ></i> <span id="_su_engagement">0</span> Total engagements
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <div class="card card-services-highlights pb-2 c-gray">
                                    <div class="card-body">
                                        <div id="_redirect_title"><h3 class="font-18">Redirect</h3></div>
                                        <div id="" class="redirect-link custom-tooltip mt--5"><i class="uil uil-link"></i><span id="_su_redirect_url">....</span></div>
                                    </div>
                                </div>

                                <div class="card card-services-highlights pt-1 pb-2  c-gray">
                                    <div class="card-body placeholder-glow">
                                        
                                        <h4 class="card-title mb-3" id="_engagement_overview_title">Engagement Overview</h4>
                                        <div dir="ltr">
                                            <canvas id="_clicks_overview" class="apex-charts mt-3"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-services-highlights pt-1 pb-2 c-gray">
                                <div class="card-body">
                                    <h4 class="card-title mb-3" id="_location_title">Location</h4> 
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
                                    <div class="row">
                                        <div class="col-lg-6 mb-2 mt-2">
                                        <h4 class="card-title mb-3" id="_browser_title">Browser</h4>
                                            <div>
                                                <canvas id="_browser_overview" class="apex-charts mt-3"></canvas>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-2 mt-2">
                                        <h4 class="card-title mb-3" id="_platform_title">Platform</h4>
                                            <div>
                                                <canvas id="_platform_overview" class="apex-charts mt-3"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card card-services-highlights pt-1 pb-2 c-gray">
                                <div class="card-body">
                                    <h4 class="card-title mb-3" id="_referrer_title">Referrer</h4>
                                    <div class="row">
                                        <div class="col-lg-12 mb-2 mt-2">
                                            <div dir="ltr">
                                                <canvas id="_referrer_overview" class="apex-charts mt-3"></canvas>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div> 
                               
                            </div>
                        </div>

                        <div class="modal fade margin-top-10" id="_qr_code_modal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1"  aria-labelledby="_add_user_modal" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content br-10">
                                    <div class="modal-body">
                                        <div class="container-fluid">   
                                            <h3 class="text-left text-capitalize margin-top-10 fw-300"> <i class="uil uil-qrcode-scan"></i> QR Code</h3>
                                                                
                                            <form id="_registration_form" class="mb-3">
                                                <div class="row">
                                                    <div class="col-lg-12 mt-2">
                                                        <p class="font-14">
                                                            Share your QR code!
                                                        </p>
                                                        <div class="text-center" id="_url_wrap">
                                                            <div class="qr_code " id="_qr_code">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-center mt-1 ">
                                                            <div class="margin-right-10" id="_dl_btn_div">
                                                                <button class="btn col-5"> Download</button>
                                                            </div>
                                                            <div class=" margin-right-10" id="_upload_btn_div">
                                                                <button class="btn col-5"> Upload image</button>
                                                            </div>
                                                        </div>
                                                        <div class="text-end mt-2">
                                                            <button class="btn btn-md btn-secondary rounded" id="_close_qrcode_btn" type="button">Close</button>
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
                                            <h3 class="text-left text-capitalize margin-top-20 fw-300"> <i class="uil uil-upload-alt"></i> Upload Image</h3>
                                            <div class="mb-2">
                                                <img alt="Logo image" src="<?=base_url('assets/images/thumbnail.webp')?>" id="_logo_thumbnail" width="220" class="br-10 cursor-pointer" >
                                            </div>
                                                                
                                            <form id="_acct_upload_img_form" class="mb-3">
                                                <div class="row">
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="custom-file">
                                                            <label class="form-label">Your Image</label>
                                                            <input onchange="readImageURL(this)" class="form-control" name="logo_img" id="_logo_img" type="file" required>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                                    <input type="hidden" name="url_param" class="url-param" value="">
                                                    <div class="text-end">
                                                        <button class="btn btn-md btn-success rounded" id="_upload_btn" type="submit">Upload</button>
                                                        <button class="btn btn-md btn-secondary rounded" id="_close_upload_logo_btn" type="button">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade margin-top-10" id="_new_url_modal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1"  aria-labelledby="_add_user_modal" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content br-10">
                                    <div class="modal-body">
                                        <div class="container-fluid">   
                                            <h3 class="text-left text-capitalize margin-top-15 fw-300"> <i class="uil uil-link-add"></i> Create New URL</h3>
                                                                
                                            <form id="_new_short_url_form" class="mb-3">
                                                <div class="row">
                                                    <div class="col-lg-12 mt-2">
                                                        <p class="font-14">
                                                        </p>
                                                        <div>
                                                            <label for="_redirect_url">Redirect URL</label>
                                                            <input type="text" class="form-control form-input" value="" id="_redirect_url" name="redirect_url" placeholder="http://" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mt-3 col-lg-6">
                                                                <label for="">Custom Link</label>
                                                                <input type="text" class="form-control form-input" value="<?=str_replace(array('https://','http://'),'',base_url('/'))?>" id="" name="" readonly>
                                                            </div>
                                                            <div class="mt-3 col-lg-6">
                                                                <label for="_custom_link"></label>
                                                                <input type="text" class="form-control form-input" value="" id="_custom_link" name="custom_link" placeholder="Optional">
                                                            </div>

                                                        </div>

                                                        <div class="mt-3">
                                                            <label for="_custom_title">Title</label>
                                                            <input type="text" class="form-control form-input" value="" id="_custom_title" name="title" placeholder="Optional">
                                                        </div>
                                                        <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                                        <div class="text-end mt-3">
                                                            <button class="btn btn-md btn-success rounded" id="_create_new_url_btn" type="submit">Create</button>
                                                            <button class="btn btn-md btn-secondary rounded" data-bs-dismiss="modal" type="button">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>          

                        <div class="modal fade margin-top-10" id="_edit_url_modal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1"  aria-labelledby="_add_user_modal" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content br-10">
                                    <div class="modal-body">
                                        <div class="container-fluid">   
                                            <h3 class="text-left text-capitalize margin-top-15 fw-300"> <i class="uil uil-link-alt"></i> Customize URL</h3>
                                            <form id="_edit_short_url_form" class="mb-3">
                                                <div class="row">
                                                    <div class="col-lg-12 mt-2">
                                                        <p class="font-14">Changing this URL will result to inaccessible of your previous edited URLs!
                                                        </p>
                                                        <div>
                                                            <label for="_redirect_url">Redirect URL</label>
                                                            <input type="text" class="form-control form-input" value="" id="_edit_redirect_url" name="redirect_url" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mt-3 col-lg-6">
                                                                <label for="">Custom Link</label>
                                                                <input type="text" class="form-control form-input" value="<?=str_replace(array('https://','http://'),'',base_url('/')); ?>" readonly>
                                                            </div>
                                                            <div class="mt-3 col-lg-6">
                                                                <label for="_custom_link"></label>
                                                                <input type="text" class="form-control form-input" value="" id="_custom_edit_link" name="custom_link" required>
                                                            </div>

                                                        </div>

                                                        <div class="mt-3">
                                                            <label for="_custom_title">Title</label>
                                                            <input type="text" class="form-control form-input" value="" id="_custom_edit_title" name="title" placeholder="Optional">
                                                        </div>
                                                        <input type="hidden" name="url_param_edit" id="_url_param_edit" value="">
                                                        <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                                        <div class="text-end mt-3">
                                                            <button class="btn btn-md btn-success rounded" id="_save_url_btn" type="submit">Save</button>
                                                            <button class="btn btn-md btn-secondary rounded" data-bs-dismiss="modal" type="button">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>        
                         
