                
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
                            
                            <div class="col-xl-12 col-lg-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-lg-5 mt-2">
                                           <form class=" gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" id="_search_user_form">
                                            <div class="col-auto">
                                                <label for="_keyword" class="visually-hidden">Search</label>
                                                <input type="search" class="form-control" name="search" id="_search" placeholder="URL parameter, website. etc.">
                                            </div>
                                            </form>  
                                        </div>
                                        <div class="col-lg-7 mt-2">
                                            <div class="mt-xl-0 text-end">
                                                <button type="button" class="btn rounded btn-light mb-2" onclick="_getUsersList(1,'','')"><i class="uil-redo"></i> Refresh</button>
                                            </div>
                                        </div>  
                                    </div>
                                        <h1 class="card-title mb-3"></h1>
                                        <div class="table-responsive">
                                        <table class="table table-c_refreshTxListentered table-hover mb-0 font-12">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="_loan_check_all" class="form-check-input cursor-pointer" id="_loan_check_all">
                                                        <label class="form-check-label" for="_loan_check_all">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Username</th>
                                                    <th>Log</th>
                                                    <th>IP Address</th>
                                                    <th>Browser</th>
                                                    <th>Date & Time</th>
                                                </tr>
                                            </thead>
                                            <tbody id="activity_logs">
                                            </tbody>
                                        </table>
                                        <div class="row mb-4">
                                            <div class="col-lg-6">
                                                <div class="mt-2  text-start" id="_user_pagination"></div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-2 text-end" id="_user_count"></div>
                                            </div>
                                        </div>

                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>
                        <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
