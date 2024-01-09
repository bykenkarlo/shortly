                
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
                                           <form class=" gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" id="_search_ad">
                                            <div class="col-auto">
                                                <label for="_keyword" class="visually-hidden">Search</label>
                                                <input type="search" class="form-control" name="search" id="_search" placeholder="Name, URL, etc..">
                                            </div>
                                            </form>  
                                        </div>
                                        <div class="col-lg-7 mt-2">
                                            <div class="mt-xl-0 text-end">
                                                <button type="button" class="btn rounded btn-light mb-2" onclick="refreshAdsList()"><i class="uil-redo"></i> Refresh</button>
                                                <button type="button" class="btn rounded btn-success mb-2" id="add_new"><i class="uil-file-plus-alt"></i> Add New</button>
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
                                                            <input type="checkbox" name="check_all" class="form-check-input cursor-pointer" id="check_all">
                                                        <label class="form-check-label" for="check_all">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Name</th>
                                                    <th>URL</th>
                                                    <th>Type</th>
                                                    <th>Clicks</th>
                                                    <th>Status</th>
                                                    <th>Created Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ads_tbl">
                                            </tbody>
                                        </table>
                                        <div class="row mb-4">
                                            <div class="col-lg-6">
                                                <div class="mt-2  text-start" id="ads_pagination"></div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-2 text-end" id="ads_count"></div>
                                            </div>
                                        </div>

                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>
                        <div class="modal fade margin-top-10" id="new_ad_modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content br-10">
                                    <form id="new_ad_form" class="margin-bottom-30 margin-top-20">
                                    <div class="modal-body">
                                        <div class="">
                                            <div class="container">
                                                <h3 class="text-left" style="font-weight: 300; color: #3c3c3d;" class="text-capitalize margin-top-40"> <i class="uil-plus"></i> Add New</h3>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                             <div class="mt-2">
                                                                <select name="type" id="type" class="form-control" required>
                                                                    <option value="" selected ="disabled" readonly >Select Type</option>
                                                                    <option value="button">Button</option>
                                                                    <option value="banner">Banner</option>
                                                                    <option value="url">URL</option>
                                                                </select> 
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mt-2">
                                                                <input type="text" name="name" class="form-control" id="ad_name" placeholder="Name" required autofocus>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6" hidden="hidden" id="button_text_wrapper">
                                                             <div class="mt-2">
                                                                <input type="text" name="button_text" class="form-control" id="button_text" placeholder="Button Text" >
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6" hidden="hidden" id="button_color_wrapper">
                                                             <div class="mt-2">
                                                                <input type="text" name="button_color" class="form-control" id="button_color" placeholder="Button color by Hex code" >
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6" hidden="hidden" id="logo_wrapper">
                                                             <div class="mt-2">
                                                                <input type="text" name="logo" class="form-control" id="logo" placeholder="Logo URL" >
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                             <div class="mt-2">
                                                                <input type="text" name="url" class="form-control" id="ad_url" placeholder="Redirect URL" required >
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6" id="banner_wrapper" hidden="hidden">
                                                             <div class="mt-2">
                                                                <input type="text" name="banner" class="form-control" id="banner" placeholder="Image URL" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-lg-12">
                                                             <div class="mt-2">
                                                                <textarea name="description" class="form-control" id="description" placeholder="Description" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                        </div>
                                        <div class="text-end mb-2 mt-2">
                                            <button class="btn btn-success rounded" type="submit" id="new_ad">Save</button>
                                            <button class="btn btn-secondary rounded" type="button" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
