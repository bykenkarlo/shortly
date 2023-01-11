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
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('7_days')" href="#">Last 7 days</a>
                                                <a class="dropdown-item " onclick="_getWebsiteVisitsStatistics('15_days')" href="#">Last 15 days</a>
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('1_month')" href="#">Last 30 days</a>
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('1_year')" href="#">1 year</a>
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
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('7_days')" href="#">Last 7 days</a>
                                                <a class="dropdown-item " onclick="_getWebsiteVisitsStatistics('15_days')" href="#">Last 15 days</a>
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('1_month')" href="#">Last 30 days</a>
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('1_year')" href="#">1 year</a>
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
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('7_days')" href="#">Last 7 days</a>
                                                <a class="dropdown-item " onclick="_getWebsiteVisitsStatistics('15_days')" href="#">Last 15 days</a>
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('1_month')" href="#">Last 30 days</a>
                                                <a class="dropdown-item" onclick="_getWebsiteVisitsStatistics('1_year')" href="#">1 year</a>
                                            </div>
                                        </div>
                                          <h1 class="card-title mb-3">Link Clicks Overview</h1>
                                        <div dir="ltr">
                                            <canvas id="_link_clicks_chart" class="apex-charts mt-3"></canvas>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>
