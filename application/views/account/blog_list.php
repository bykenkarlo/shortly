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
                           
                            <div class="col-xl-12 col-lg-6">
                                <div class="card card-h-100">
                                    <div class="card-body table-responsive ">
                                        <h4 class="header-title mb-3"></h4>
                                        <div>
                                            <div class="row mb-2">
                                                <div class="col-xl-6">
                                                    <form class="row gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" id="_search_article_form">
                                                        <div class="col-auto">
                                                            <label for="_keyword" class="visually-hidden">Search</label>
                                                            <input type="search" class="form-control" name="search" id="_search" placeholder="Search...">
                                                        </div>
                                                    </form>                            
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="text-xl-end mt-xl-0 mt-2">
                                                        <a href="<?=base_url('account/blog/new');?>" class="btn btn-success rounded c-white mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Article</a>

                                                        <button id="_show_categories_btn" type="button" class="btn btn-light rounded btn mb-2"><i class="uil-create-dashboard"></i> Categories</button>
                                                        <button type="button" class="btn rounded btn-light mb-2" onclick="_refreshBlogList()"><i class="uil-redo"></i> Refresh</button>

                                                    </div>
                                                </div><!-- end col-->
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <table class="table table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Published</th>
                                                        <th>Created Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="_blog_tbl">
                                                </tbody>
                                            </table>

                                            <div class="row mb-4">
                                                <div class="col-lg-6">
                                                    <div class="mt-2  text-start" id="_blog_tbl_pagination"></div>
                                                </div>
                                                <div class="col-lg-6 ">
                                                    <div class="mt-2 text-end-start" id="_blog_count"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div dir="ltr">
                                            <!-- <div id="high-performing-product" class="apex-charts" data-colors="#727cf5,#e3eaef"></div> -->
                                        </div>

                                        <!-- <div style="height: 263px;" class="chartjs-chart">
                                            <canvas id="high-performing-product"></canvas>
                                        </div> -->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                       
                    </div>
                        <!-- end row -->


                    <div class="modal fade margin-top-10" id="_categories_modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="">
                                        <div class="container">
                                            <h3 class="text-left" style="font-weight: 300; color: #3c3c3d;" class="text-capitalize margin-top-40"> <i class="uil-create-dashboard"></i> Categories <button class="btn btn-primary btn-sm" id="_add_category_btn"><i class="uil-plus-circle"></i> Add</button></h3>
                                            <div class="margin-bottom-30 margin-top-20">
                                                <div id="_add_category_form_div" class="margin-top-20" hidden="hidden">
                                                    <form id="_add_category_form" class="">
                                                        <div class="category-wrapper">
                                                            <div class="form-floating">
                                                                <input type="text" name="category" class="form-control" id="_category_name" />
                                                                <label for="_category_name">Category</label>
                                                            </div>
                                                            <div class="alert-tooltip" hidden="hidden"></div>
                                                        </div>

                                                        <div class="text-end ">
                                                            <button class="btn btn-secondary margin-top-10 " id="_cancel_category_btn" type="button">Cancel</button>
                                                            <button class="btn btn-success margin-top-10 c-white" id="_submit_category_btn"  type="submit">Save</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="margin-top-10 table-responsive">
                                                    <table class="table table-hover font-14">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Date Added</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="_category_tbl">
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div id="_category_tbl_pagination" class="mt-2">
                                                </div>

                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="text-end mb-2 mt-2">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">

