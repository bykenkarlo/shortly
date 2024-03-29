
	<div id="_web_container">
		<div class="other-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5  margin-top-40">
                        <div class="card ">
                            <div class="card-header pt-2 pb-2 text-center bg-success rounded">
                                <span>
                                    <a href="#" onclick="_accessPage('')">
                                        <h1 class="c-white fw-600 font-23 pt-1 pb-1">
                                            Log In Account
                                        </h1>
                                    </a>
                                </span>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <!-- <h1 class="text-dark-50 text-center mt-0 fw-bold mb-2 font-23">Log In Account</h1> -->
                                </div>
                                <form action="#" id="_login_form">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="username" name="username" required="" placeholder="Enter your Username" />
                                        <label for="username" class="fw-400">Username</label>
                                    </div>
                
                                    <div class="form-floating ">
                                        <input type="password" id="_password" name="password" class="form-control " placeholder="Enter your password" />
                                        <label for="password" class="fw-400">Password</label>
                                    </div>
                                    <div class="mt-1 text-sm-start">
                                        <div class="mt-1 pointer-cursor">
                                            <small id="_show_password" onclick="_showPassword()">
                                            	<span class="pointer-cursor" ></span><i class="uil-eye "></i> Show Password
                                            </small>
                                            <small hidden id="_hide_password" onclick="_hidePassword()">
                                            	<span class="pointer-cursor" ></span><i class="uil-eye-slash "></i> Hide Password
                                            </small>
                                        </div>
                                    </div>
                                    <div class="mt-2 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" value="<?=$login_token?>" name="remember_login" id="remember_login">
                                            <label class="form-check-label" for="remember_login">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-0 text-center">
                                        <button class="btn btn-success text-white rounded k-btn btn-lg col-lg-12 col-12 font-17" id="_login_btn" type="submit"> Log In </button>
                                    </div>
                                    <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                    <input type="hidden" name="last_url" value="<?=(isset($_GET['return'])) ? $_GET['return'] : '';?>">
                                    <div class="text-center mb-3">
                                        <button type="button" class="btn-link btn text-success" id="_forgot_password">Forgot Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal fade" id="account_recovery_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-md " >
                                <div class="modal-content br-10">
                                    <div class="modal-header ">
                                        <h4 class="modal-title " id="myLargeModalLabel">Recover Account</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="_forgot_password_form" class="mt-2">
                                            <div class="row">
                                                <div class="form-floating mb-3 col-lg-12">
                                                    <input name="user_email" type="text" class="form-control" id="_user_email" placeholder="" required="required"/>
                                                    <label for="user_email" class="fw-400">Email address</label>
                                                </div>
                                            </div>
                                            <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                                            <div class="mt-1 pb-2 float-end">
                                                <button id="recovery_btn" type="submit" class="btn rounded btn-success c-white">Send Recovery Email</button>
                                                <button type="button" class="btn rounded btn-secondary c-white" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                       </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
