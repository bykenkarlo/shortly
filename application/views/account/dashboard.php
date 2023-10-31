<div class="content-page">
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
                            <div class="col-xl-3 col-lg-4">
                                <div class="card tilebox-one">
                                    <div class="card-body">
                                        <i class='uil uil-user-location float-end'></i>
                                        <h6 class="text-uppercase mt-0" >Visits Today</h6>
                                        <h2 class="my-2 font-22" id="_visits_today">0</h2>
                                    </div> 
                                </div>
                                <div class="card tilebox-one">
                                    <div class="card-body">
                                        <i class='uil uil-link float-end'></i>
                                        <h6 class="text-uppercase mt-0">Total Links Created</h6>
                                        <h2 class="my-2 font-22" id="_links_created">0</h2>
                                    </div>
                                </div>
                                <div class="card tilebox-one">
                                    <div class="card-body">
                                        <i class='uil uil-location-arrow float-end'></i>
                                        <h6 class="text-uppercase mt-0">Total Link Clicks</h6>
                                        <h2 class="my-2 font-22" id="_link_clicks">0</h2>
                                        <p class="mb-0 text-muted">
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-xl-9 col-lg-8 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#website_visit_stat" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="getSiteVisits('today')" href="#website_visit_stat">Today</a>
                                                <a class="dropdown-item" onclick="getSiteVisits('7_days')" href="#website_visit_stat">Last 7 days</a>
                                                <a class="dropdown-item" onclick="getSiteVisits('15_days')" href="#website_visit_stat">Last 15 days</a>
                                                <a class="dropdown-item" onclick="getSiteVisits('1_month')" href="#website_visit_stat">Last 30 days</a>
                                                <a class="dropdown-item" onclick="getSiteVisits('1_year')" href="#website_visit_stat">1 year</a>
                                            </div>
                                        </div>
                                          <h1 class="card-title mb-3">Website Visitors Overview</h1>
                                        <div dir="ltr">
                                            <canvas id="_website_visits" class="apex-charts mt-3"></canvas>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <div class="card mt-2">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#link_created_stat" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="linkCreatedChart('today')" href="#link_created_stat">Today</a>
                                                <a class="dropdown-item" onclick="linkCreatedChart('7_days')" href="#link_created_stat">Last 7 days</a>
                                                <a class="dropdown-item" onclick="linkCreatedChart('15_days')" href="#link_created_stat">Last 15 days</a>
                                                <a class="dropdown-item" onclick="linkCreatedChart('1_month')" href="#link_created_stat">Last 30 days</a>
                                                <a class="dropdown-item" onclick="linkCreatedChart('1_year')" href="#link_created_stat">1 year</a>
                                            </div>
                                        </div>
                                          <h1 class="card-title mb-3">Link Created Overview</h1>
                                        <div dir="ltr">
                                            <canvas id="_link_created" class="apex-charts mt-3"></canvas>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <div class="card mt-2">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#link_click_stat" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="linkCountChart('today')" href="#link_click_stat">Today</a>
                                                <a class="dropdown-item" onclick="linkCountChart('7_days')" href="#"link_click_stat>Last 7 days</a>
                                                <a class="dropdown-item" onclick="linkCountChart('15_days')" href="#link_click_stat">Last 15 days</a>
                                                <a class="dropdown-item" onclick="linkCountChart('1_month')" href="#link_click_stat">Last 30 days</a>
                                                <a class="dropdown-item" onclick="linkCountChart('1_year')" href="#link_click_stat">1 year</a>
                                            </div>
                                        </div>
                                          <h1 class="card-title mb-3">Link Clicks Overview</h1>
                                        <div dir="ltr">
                                            <canvas id="_link_clicks_chart" class="apex-charts mt-3"></canvas>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <div class="card mt-2">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#location_stat" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="locationChart('today')" href="#location_stat">Today</a>
                                                <a class="dropdown-item" onclick="locationChart('7_days')" href="#location_stat">Last 7 days</a>
                                                <a class="dropdown-item " onclick="locationChart('15_days')" href="#location_stat">Last 15 days</a>
                                                <a class="dropdown-item" onclick="locationChart('1_month')" href="#location_stat">Last 30 days</a>
                                                <a class="dropdown-item" onclick="locationChart('1_year')" href="#location_stat">1 year</a>
                                            </div>
                                        </div>
                                          <h1 class="card-title mb-3">Location</h1>
                                        <div dir="ltr">
                                        <div class="row" id="_location_chart">
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <div class="card mt-2">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#most_viewed_url_stat" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="mostViewedURL('today')" href="#most_viewed_url_stat">Today</a>
                                                <a class="dropdown-item" onclick="mostViewedURL('7_days')" href="#most_viewed_url_stat">Last 7 days</a>
                                                <a class="dropdown-item" onclick="mostViewedURL('15_days')" href="#most_viewed_url_stat">Last 15 days</a>
                                                <a class="dropdown-item" onclick="mostViewedURL('1_month')" href="#most_viewed_url_stat">Last 30 days</a>
                                                <a class="dropdown-item" onclick="mostViewedURL('1_year')" href="#most_viewed_url_stat">1 year</a>
                                            </div>
                                        </div>
                                          <h1 class="card-title mb-3">Most Viewed URL</h1>
                                        <div dir="ltr">
                                        <div class="row" id="_most_viewed_url_chart">
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <div class="card card-services-highlights mt-2 c-gray">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#browser_platform_stat" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="browserPlatformStat('today')" href="#browser_platform_stat">Today</a>
                                                <a class="dropdown-item" onclick="browserPlatformStat('7_days')" href="#browser_platform_stat">Last 7 days</a>
                                                <a class="dropdown-item" onclick="browserPlatformStat('15_days')" href="#browser_platform_stat">Last 15 days</a>
                                                <a class="dropdown-item" onclick="browserPlatformStat('1_month')" href="#browser_platform_stat">Last 30 days</a>
                                                <a class="dropdown-item" onclick="browserPlatformStat('1_year')" href="#browser_platform_stat">1 year</a>
                                            </div>
                                        </div>
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
