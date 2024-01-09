    


    <!-- Topbar Start -->
    <div class="navbar-custom topnav-navbar topnav-navbar-light">
        <div class="container-fluid">

            <!-- LOGO -->
            <a href="<?=base_url();?>" class="topnav-logo cursor-pointer">
                <span class="topnav-logo-lg">
                    <img src="<?=base_url('assets/images/logo/hh-logo.webp')?>" alt="" height="40">
                </span>
                <span class="topnav-logo-sm">
                    <img src="<?=base_url('assets/images/logo/mm-logo.webp')?>" alt="" height="36">
                </span>
            </a>

            <ul class="list-unstyled topbar-menu float-end mb-0">

                <!-- <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="dripicons-bell noti-icon"></i>
                        <span class="noti-icon-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg" aria-labelledby="topbar-notifydrop">

                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-end">
                                    <a href="javascript: void(0);" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div style="max-height: 230px;" data-simplebar>
                            
                        </div>

                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                            View All
                        </a>

                    </div>
                </li> -->

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="account-user-avatar"> 
                            <!-- <img src="assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle"> -->
                            <i class="uil uil-user-circle rounded-circle font-40" ></i>
                        </span>
                        <span>
                            <span class="account-user-name"></span>
                            <span class="account-position text-capitalize"><?= ($user_data['user_type'] == 'sys_admin') ? 'System Admin' : str_replace('_',' ',ucwords($user_data['user_type']))?></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="<?=base_url('account/dashboard')?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle me-1"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="<?=base_url('account/settings')?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-cog me-1"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="<?=base_url('logout')?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout me-1"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>

            </ul>
            <a class="button-menu-mobile disable-btn">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
        
        </div>
    </div>
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="wrapper">
            <div class="leftside-menu leftside-menu-detached" id="_leftside_menu">

                <div class="leftbar-user">
                    <a href="javascript: void(0);" id="_profile_left_sidebar">
                        <img src="<?=base_url().$user_data['profile_image']?>" onError="_imgError(this);" alt="user-image" height="100" width="100" class="rounded-circle shadow-sm">
                        <span class="leftbar-user-name"></span>
                    </a>
                </div>
                <ul class="side-nav">
                    <li class="side-nav-title side-nav-item">Navigation</li>
                    <li class="side-nav-item">
                        <a href="<?=base_url();?>" class="side-nav-link">
                            <i class="uil-estate"></i>
                            <span> Home </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a  href="<?=base_url('account/dashboard');?>" class="side-nav-link dashboard <?=($state=='dashboard')?'active':'';?>">
                            <i class="uil-sliders-v-alt"></i>
                            <span class=""> Dashboard </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a  href="<?=base_url('account/url-list');?>" class="side-nav-link dashboard <?=($state=='url_list')?'active':'';?>">
                            <i class="uil-link"></i>
                            <span class=""> URL Lists </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a  href="<?=base_url('account/ads');?>" class="side-nav-link dashboard <?=($state=='ads')?'active':'';?>">
                            <i class="uil-file-info-alt"></i>
                            <span class=""> Advertisements </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?=base_url('account/blog')?>" class="side-nav-link blog <?=($state =='blog_list')?'active':'';?>">
                            <i class="uil-document-layout-left "></i>
                            <span class=""> Blog </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?=base_url('account/users-list')?>" class="side-nav-link users-list <?=($state =='users_list')?'active':'';?>">
                            <i class="uil-users-alt "></i>
                            <span class=""> Users List </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?=base_url('account/activity-logs')?>" class="side-nav-link website-settings <?=($state =='activity_logs')?'active':'';?>">
                            <i class="uil-list-ol-alt "></i>
                            <span> Activity Logs </span>
                            <!-- <span class="menu-arrow"></span> -->
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>