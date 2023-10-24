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
                            <div class="col-xl-12 col-lg-12 col-12 mb-4">
                            <input type="text"  id="secret" hidden="hidden" class="hidden" value="<?=$this->session->secret_key?>">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="short-summary">
                                            <div class="su-title">
                                                <h1 class="card-title mb-3 font-20 fw-700" id="_su_title">Update Email</h1>    
                                            </div>
                                            <div>
                                            <form id="_update_email_form" class="mb-3">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <p class="font-14">
                                                            This email address will only be used for recovering your account in case you forgot your secret key. 
                                                        </p>
                                                        <div>
                                                            <label for="_redirect_url">Email Address</label>
                                                            <input type="text" class="form-control form-input" id="_email_address" value="<?=$user_data['email_address']?>" name="email_address" required placeholder="username@gmail.com">
                                                            <?php if( $user_data['email_verified'] == 'yes') {?>
                                                            <small class="text-success"><i class="uil uil-check-circle"></i> Email Verified</small>
                                                            <?php } else if($user_data['email_verified'] == 'no') { ?><small class="text-secondary"><i class="uil uil-times-circle"></i> Email not yet verified</small>
                                                            <?php } else if($user_data['email_verified'] == 'pending') { ?><small class="text-secondary"><i class="uil uil-clock"></i> Email is sent to the email address and need for verification.</small><?php }?>
                                                        </div>

                                                        <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                                        <div class="text-end mt-2">
                                                            <button class="btn btn-md btn-success rounded" id="_save_email_btn" type="submit">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="short-summary">
                                            <div class="su-title">
                                                <h1 class="card-title mb-3 font-20 fw-700" id="_su_title">Secret Key</h1>    
                                            </div>
                                            <div>
                                            <form id="_edit_short_url_form" class="mb-3">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <p class="font-14">
                                                            Your secret key is like your username and password. This will be used to access your account.
                                                        </p>
                                                        <div>
                                                            <label for="_redirect_url">Secret Key</label>
                                                            <input type="password" class="form-control form-input" id="secret_key" name="" value="<?=$this->session->secret_key?>" readonly>
                                                            <button type="button" class="btn btn-light rounded mt-2 float-end me-1" id="show_secret">Show</button>
                                                            <button type="button" class="btn btn-light rounded mt-2 float-end me-1" hidden="hidden" id="hide_secret">Hide</button>
                                                            <button type="button" id="_copy_secret" data-clipboard-target="#secret_key" class="btn btn-success rounded mt-2 float-end">Copy</button>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="short-summary">
                                            <div class="su-title">
                                                <h1 class="card-title mb-3 font-20 fw-700" id="_su_title">Generate New Secret Key</h1>    
                                            </div>
                                            <div>
                                            <form id="_edit_short_url_form" class="mb-3">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <p class="font-14">
                                                            Your current secret key will be deleted and will be replaced with a new secret key.
                                                        </p>
                                                        <div>
                                                            <button type="button" id="generate_new_secret_key" class="btn btn-success rounded mt-2 float-start">Generate</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                            </div> 
                            