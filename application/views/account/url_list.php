                
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
                                           <form class=" gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" id="_search_url_form">
                                            <div class="col-auto">
                                                <label for="_keyword" class="visually-hidden">Search</label>
                                                <input type="search" class="form-control" name="search" id="_search" placeholder="URL parameter, website. etc.">
                                            </div>
                                            </form>  
                                        </div>
                                        <div class="col-lg-7 mt-2">
                                            <div class="mt-xl-0 text-end">
                                                <button type="button" class="btn rounded btn-light mb-2" onclick="_getUrlList(1,'','')"><i class="uil-redo"></i> Refresh</button>
                                                <button type="button" class="btn rounded btn-secondary mb-2" onclick="checkLink()"><i class="uil-redo"></i> Check Google Safe</button>
                                            </div>
                                        </div>  
                                    </div>
                                        <h1 class="card-title mb-3">Shortened URLs List</h1>
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
                                                    <th>Shortened URL</th>
                                                    <th width="350">Long URL</th>
                                                    <th>Click Count</th>
                                                    <th>Status</th>
                                                    <th>Date Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="_url_tbl">
                                            </tbody>
                                        </table>
                                        <div class="row mb-4">
                                            <div class="col-lg-6">
                                                <div class="mt-2  text-start" id="_url_pagination"></div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-2 text-end" id="_url_count"></div>
                                            </div>
                                        </div>

                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <div class="card mt-3">
                                    <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-lg-5 mt-2">
                                           <form class=" gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" id="_search_url_form">
                                            <div class="col-auto">
                                                <label for="_keyword" class="visually-hidden">Search</label>
                                                <input type="search" class="form-control" name="search" id="_search" placeholder="URL parameter, website. etc.">
                                            </div>
                                            </form>  
                                        </div>
                                        <div class="col-lg-7 mt-2">
                                            <div class="mt-xl-0 text-end">
                                            <button type="button" class="btn rounded btn-success mb-2" id="add_blocklist_url"><i class="uil-plus"></i> Add URL</button>
                                                <button type="button" class="btn rounded btn-light mb-2" onclick="_getBlocklistUrlList(1,'','')"><i class="uil-redo"></i> Refresh</button>
                                            </div>
                                        </div>  
                                    </div>
                                        <h1 class="card-title mb-3">Blocklisted URLs</h1>
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
                                                    <th width="400">URL</th>
                                                    <th>Note</th>
                                                    <th>Date Blocklisted</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="_blocklist_url_tbl">
                                            </tbody>
                                        </table>
                                        <div class="row mb-4">
                                            <div class="col-lg-6">
                                                <div class="mt-2  text-start" id="_blocklist_url_pagination"></div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-2 text-end" id="_blocklist_url_count"></div>
                                            </div>
                                        </div>

                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>

                        <div class="modal fade margin-top-10" id="_add_blocklist_modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="">
                                            <div class="container">
                                                <h3 class="text-left" style="font-weight: 300; color: #3c3c3d;" class="text-capitalize margin-top-40"> <i class="uil-plus"></i> Add URL</h3>
                                                <form id="_blocklist_form" class="margin-bottom-30 margin-top-20">
                                                    <div class="mt-2">
                                                        <input type="text" name="url" class="form-control" id="_blocklist_url" placeholder="Link"  required autofocus>
                                                    </div>
                                                    <div class="mt-2">
                                                        <textarea name="note" class="form-control" id="_note" placeholder="Note here..." ></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                        </div>
                                        <div class="text-end mb-2 mt-2">
                                            <button class="btn btn-success rounded" id="_save_blocklist_url">Save</button>
                                            <button class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
