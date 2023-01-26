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
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 mb-3">
                                                <form id="_update_image_form">
                                                    <div class="mb-2">
                                                        <img alt="Featured article image" src="<?=$article_data['article_image']?>" id="_article_thumbnail" width="500" class="img-fluid br-10 cursor-pointer" onclick="uploadArticleImageFile()">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-md-12mb-3">
                                                                <div class="custom-file">
                                                                    <label class="form-label">Article Image</label>
                                                                    <input onchange="readURL(this)" class="form-control" name="article_image" id="_article_img" type="file" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button class="btn btn-success rounded c-white" type="submit" id="_update_image_btn">Update Image</button>
                                                        <button class="btn btn-secondary rounded c-white" type="button" id="_upload_more_images">Images</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <form id="_edit_blog_form">
                                            <div class="row">
                                                <div class="col-md-6 col-xs-12 mb-3">
                                                    <select name="category" class="form-control select2" data-toggle="select2" required>
                                                        <option value="<?=$article_data['category_id']?>" selected><?=$article_data['category']?></option>
                                                        <?php foreach($blog_category as $bc) { ?>
                                                        <option value="<?=$bc['id']?>"><?=$bc['name']?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" name="title" class="form-control" value="<?=$article_data['title']?>" id="_article_title_update" required/>
                                                    <label for="_article_title_update">Title</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" name="url" value="<?=$article_data['url']?>" class="form-control text-lowercase" id="_article_url" required/>
                                                    <label for="_article_url">Article URL</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" name="description" id="_article_desc"  required><?=$article_data['description']?></textarea>
                                                    <label for="_article_desc">Description</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control tinymce_inputs"  id="_lead" placeholder="Write your lead here..." required><?=$article_data['lead']?></textarea>
                                                    <label for="_lead">Lead</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control tinymce_inputs" placeholder="Write your content here..." id="_new_blog_content" required><?=$article_data['content']?></textarea>
                                                    <label for="_new_blog_content">Content</label>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <div class="row ">
                                                        <label for="floatingTextarea" class="mb-2">Tags</label>
                                                         <div class="col-lg-4" id="_tags_div">
                                                            <input class="form-control" id="_add_tags" placeholder="ex. Technology" type="text">
                                                            <div class="alert-tooltip" hidden="hidden"></div>
                                                            <button class="btn btn-sm btn-success c-white mt-1" type="button" id="_add_tags_btn_update_form">Add Tags</button>
                                                        </div>

                                                        <div class="mt-3" id="_added_tags_show">
                                                            <?php  $count = 0; foreach ($article_data['tags'] as $tags){ 
                                                                $count++;
                                                            ?>
                                                            <span class="multiple-tags" id="_tag_<?=$tags['id']?>"><?=$tags['tags']?>
                                                                <span onclick="_deleteArticleTag(<?=$tags['id']?>)" class="remove-tag-icon"><i class="uil-times"></i></span>
                                                            </span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>" />
                                                <input type="hidden" id="_article_id" name="article_id" value="<?=$article_data['article_pub_id']?>" />
                                                <input type="hidden" id="_id" value="<?=$article_data['article_id']?>" />
                                                

                                                <div class="sticky-buttons-wrapper">
                                                    <div class="mb-2 text-end mt-2" >
                                                        <button type="button" class="btn rounded font-17 c-white btn-secondary mt-1" onclick="window.location='<?=base_url('account/blog')?>'">Back</button>
                                                        <button type="button" class="btn btn-primary c-white rounded font-17 mt-1" onclick="_viewArticle('<?=$article_data["article_pub_id"] ?>')">View Article </button>
                                                        <button type="submit" class="btn btn-success rounded font-17 c-white mt-1" id="_update_blog_btn" >Update Article</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    <input type="hidden" id="_global_csrf" name="<?=$csrf_data['name']?>" value="<?=$csrf_data['hash']?>">
                    </div>
                    <div class="modal fade margin-top-10" id="_images_modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="">
                                        <div class="container">
                                            <h3 class="text-left" style="font-weight: 300; color: #3c3c3d;" class="text-capitalize margin-top-40"> <i class="uil-image"></i> Images</h3>
                                            <div class="margin-bottom-30 margin-top-20">
                                                <form id="_more_image_form">
                                                    <div class="mb-2">
                                                        <img alt="article image" src="<?=base_url('assets/images/thumbnail.webp')?>" id="_more_article_thumbnail" width="250" class="img-fluid br-10 cursor-pointer">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-md-12mb-3">
                                                                <div class="custom-file">
                                                                    <label class="form-label">Article Image</label>
                                                                    <input onchange="readMoreImage(this)" class="form-control" name="more_image" id="_more_img" type="file" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button class="btn btn-success rounded c-white" type="submit" id="_save_more_image_btn">Save Image</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="mt-1 mb-3">
                                                <h2 class="font-18">Images List</h2>
                                                <table class="table table-borderless font-13">
                                                    <thead>
                                                        <th>Image</th>
                                                        <th>Date Added</th>
                                                        <th>Action</th>
                                                    </thead>
                                                    <tbody id="_images_tbl">
                                                    </tbody>
                                                </table>
                                                <div class="row mb-4">
                                                    <div class="col-lg-6">
                                                        <div class="mt-2  text-start" id="_image_pagination"></div>
                                                    </div>
                                                    <div class="col-lg-6 ">
                                                        <div class="mt-2 text-end-start" id="_image_count"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end mb-2 mt-2">
                                        <button class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- end row -->
