
    <div class="">
    <!-- NAVBAR START -->
    <div class="_nav np">
        <nav class="navbar navbar-expand navbar-dark home-index-default bg-white k-header" id="_home_navbar">
            <div class="container nav-container">
                <!-- logo -->
                <div class="web-view">
                    <div class="navbar-brand me-lg-5 cursor-pointer" >
                        <a href="<?=base_url();?>"><img src="<?=base_url('assets/images/logo/hh-logo.webp')?>" alt="<?=$siteSetting['website_name']?> Logo" class="hh-logo"></a>
                    </div>
                </div>

                <div class="mobile-view d-flex justify-content-between w-100">
                    <div class="p-2 mt-1 ">
                        <div class="navbar-brand me-lg-5 cursor-pointer">
                            <a href="<?=base_url();?>"><img class="mm-logo" src="<?=base_url('assets/images/logo/hh-logo.webp')?>" alt="<?=$siteSetting['website_name']?>"></a>
                        </div>
                    </div>
                    <div class="div-nav-logo p-2">
                        
                    </div>
                    <div class="p-2 mt-1">
                        <button class="mobile-view rounded-pill font-13 btn btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#"
                        aria-controls="" aria-expanded="false" aria-label="Toggle navigation" onclick="openNav()">
                        ☰&nbsp;Menu
                        </button>
                    </div>
                </div>
                <div class="menu menu_mm trans_300 mobile-view ">
                    <div class="menu_container menu_mm">
                        <div class="page_menu_content">
                            <ul class="page_menu_nav menu_mm">
                                <li class="page_menu_item menu_mm cursor-pointer"><a href="<?=base_url()?>">Home</a></li>
                                <li class="page_menu_item menu_mm cursor-pointer"><a href="<?=base_url('about')?>">About Us</a></li>
                                <li class="page_menu_item menu_mm cursor-pointer"><a href="<?=base_url('privacy')?>">Privacy Policy</a></li>
                                <!-- <li class="page_menu_item menu_mm cursor-pointer mt-3 install-app-btn-container"><button id="_install_app" class="btn rounded btn-warning c-white ">Install App</button></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="menu_close">✕</div>
                </div>
                <!-- menu -->
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <!-- left menu -->
                        <!-- <a href="<?=base_url();?>"><img src="<?=base_url('assets/images/logo/hh-logo.webp')?>" alt="Shortly Logo" height="450"></a> -->
                    <ul class="navbar-nav me-auto align-items-right text-uppercase fw-500 web-view">
                    </ul>
                    <!-- right menu -->
                    <ul class="navbar-nav ms-auto align-items-center text-uppercase fw-500 web-view">
                        <!-- <li class="nav-item mx-lg-1">
                            <a class="nav-link" href="<?=base_url('#our_products')?>">Our Products</a>
                        </li>
                        
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link" href="<?=base_url('pay-your-loan')?>">Pay Now </a>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link" href="<?=base_url('blog')?>">Blog</a>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <a href="javascript:void(0);" class="nav-link "  onclick="_accessPage('about', 'About Us','about')">About Us</a>
                        </li>
                        <li class="nav-item mx-lg-1">
                            <div class="nav-link" onclick="_accessPage('faq', 'Faq','faq')">Faq</div>
                        </li>
                        <li class="nav-item me-0">
                            <a  href="<?=base_url('borrow?').'utm_source=self&utm_medium=btn&utm_campaign=borrow_btn'?>"  class="btn btn-sm btn-kwartz text-uppercase c-white rounded-pill padding-right-20 padding-left-20 d-none d-lg-inline-flex btn-login">
                            Borrow
                            </a> 
                        </li> -->
                        
                        <?php if(isset($this->session->user_id)) {?>
                        <li class="dropdown text-capitalize">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0 margin-top-3" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"aria-expanded="false">
                                    <i class="uil-user-circle font-40"></i>
                                <span>
                                    <span class="account-user-name text-capitalize"></span>
                                    <span class="account-position text-capitalize"></span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <a href="<?=base_url('account/dashboard')?>" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <a href="<?=base_url('account/settings')?>" class="dropdown-item notify-item">
                                    <i class="mdi mdi-cog me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <a href="<?=base_url('logout')?>" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                        <?php } ?> 
                    </ul>

                </div>
            </div>
        </nav>
        <!-- NAVBAR END -->

                                            
    </div>
    <!-- END HERO -->
    <!-- NAVBAR END -->
