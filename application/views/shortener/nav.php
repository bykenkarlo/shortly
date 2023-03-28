    


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
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="account-user-avatar"> 
                            <!-- <img src="assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle"> -->
                            <i class="uil uil-user-circle rounded-circle font-40" ></i>
                        </span>
                        <span>
                            <span class="account-user-name"></span>
                            <span class="account-position text-capitalize"><?= ($user_data['user_type'] == 'sys_admin') ? 'System Admin' : ''?></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="<?=base_url()?><?=($user_data["user_type"]=="admin")?"account/dashboard":"logged/dashboard"?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle me-1"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="<?=base_url()?><?=($user_data["user_type"]=="admin")?"account/settings":"logged/settings"?>" class="dropdown-item notify-item">
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

                <ul class="side-nav mt-4">
                    <li class="side-nav-item">
                        <a href="<?=base_url();?>" class="side-nav-link">
                            <i class="uil-estate"></i>
                            <span> Home </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?=base_url('logged/dashboard')?>" class="side-nav-link website-settings <?=($state =='account_dashboard')?'active':'';?>">
                            <i class="uil-sliders-v-alt "></i>
                            <span> Dashboard </span>
                            <!-- <span class="menu-arrow"></span> -->
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?=base_url('logged/settings')?>" class="side-nav-link website-settings <?=($state =='settings')?'active':'';?>">
                            <i class="uil uil-setting "></i>
                            <span> Settings </span>
                            <!-- <span class="menu-arrow"></span> -->
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?=base_url('logout')?>" class="side-nav-link website-settings">
                            <i class="mdi mdi-logout "></i>
                            <span> Logout </span>
                            <!-- <span class="menu-arrow"></span> -->
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>