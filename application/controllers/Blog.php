<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Blog extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->model('Blog_model');
        $this->load->model('User_model');
        $this->load->model('Csrf_model');
        $this->load->model('Site_settings_model');
    }
    
    // JS fetch
    public function getArticleDataJS(){ 
        $article_data = $this->Blog_model->getArticleDataJS();
        $article_tags = $this->Blog_model->getArticleTags($article_data['article_id']);

        if (empty($article_data['title'])) {
            $data['status'] = 'error';
            $data['message'] = 'No article found!';
        }
        else if($article_data['status'] == 'published'){
            $data['status'] = 'success';
            $data['recent_posts'] = $this->blogRecentPosts($article_data['article_pub_id']);
            // $data['related_posts'] = $this->blogRelatedPosts($article_data['category'], $article_data['article_pub_id']);
            $data['title'] = $article_data['title'];

            $tags = '';
            foreach ($article_tags as $t) {
                $tags .= '<div class="mt-2 article-tags-wrapper">
                        <a href="'.base_url('tags/').str_replace(' ','-',strtolower($t['tags'])).'" class="article-tags ">#'.$t['tags'].'
                        </a>
                    </div>';
            }

            $data['result'] = '
                    <div class="category-data text-left">
                        <a href="'.base_url('category/').''.str_replace(' ','-',strtolower($article_data['category'])).'">'.$article_data['category'].'</a>
                    </div>

                    <div class="article-title text-left">
                        <h1>'.$article_data['title'].'</h1>
                    </div>

                    <div class="article-img mt-2 text-left">
                        <img src="'.$article_data['article_image'].'" alt="'.$article_data['title'].'" class="img-fluid br-10" width="800" />
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-6 col-6 font-14 text-start">'.$article_data['created_at'].' • '.$article_data['min_read'].' min read</div>
                     </div>

                    <div class="mt-2 text-left ">
                        
                        <div class=""> 
                            <ul class="article-share-icon mt-1">
                                <li class="facebook-icon"><a href="https://www.facebook.com/sharer/sharer.php?u='.$article_data['url'].'" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-facebook-f"></i></a></li>
                                <li class="twitter-icon"><a href="https://twitter.com/intent/tweet?original_referer='.$article_data['url'].'&text='.$article_data['description'].'&url='.$article_data['url'].'&hashtags=Shortly" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-twitter"></i></a></li>
                                <li class="linkedin-icon"><a href="https://www.linkedin.com/shareArticle?mini=true&url='.$article_data['url'].'&title='.$article_data['title'].'" rel="nofollow noopener noreferrer" target="_blank"><i class="uil uil-linkedin"></i></a></li>
                            </ul>
                         </div>
                    </div>

                    <div class="content-data mt-">
                      
                        
                        <div class="content mt-3">
                            <div class="lead">
                                '.$article_data['lead'].'
                            </div>
                            '.$article_data['content'].'
                        </div>

                        <div class="content mt-3">
                            <div class="tags-wrapper">
                            '.$tags.'
                            </div>
                        </div>
                    </div>';
        }

        else if($article_data['status'] == 'draft'){
            $data['status'] = 'success';
            // $data['related_posts'] = $this->blogRelatedPosts($article_data['category'], $article_data['article_pub_id']);
            $data['recent_posts'] = $this->blogRecentPosts($article_data['article_pub_id']);
            $data['message'] = $article_data['title'];
            $data['result'] = '
                    <div class="alert alert-secondary alert-dismissible fade show mb-3" role="alert">
                        <a href="'.base_url('account/blog').'" type="button" class="btn-close" aria-label="Close"></a>
                        This article will not show in Google Pages. Update the status to "Published" first. Back to <a class="text-black fw-500" href="'.base_url('account/blog').'">Blog List</a>.
                    </div>

                    <div class="category-data text-center">
                        <a href="'.base_url('category/').''.str_replace(' ','-',strtolower($article_data['category'])).'">'.$article_data['category'].'</a>
                    </div>

                    <div class="article-title text-center">
                        <h1>'.$article_data['title'].'</h1>
                    </div>

                    <div class="inline-block font-14 text-start">'.$article_data['created_at'].'</div>
                    <div class="inline-block font-14 text-end">'.$article_data['min_read'].' min read</div>

                    <div class="content-data mt-2">

                        <div class="article-img mt-4 text-center">
                            <img src="'.$article_data['article_image'].'" class="img-fluid br-10" width="800" />
                        </div>
                        
                        <div class="content mt-3">
                            <div class="lead">
                                '.$article_data['lead'].'
                            </div>
                            '.$article_data['content'].'
                        </div>
                        <div class="mt-4">
                            <h4 class="font-20 fw-600 text-secondary">Recent Posts</h4>
                            
                        </div>
                    </div>';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));

    }
    public function blogRecentPosts($article_pub_id){
        $article_data = $this->Blog_model->blogRecentPosts( $article_pub_id);
        $html = '';
        
        if (!empty( $article_data)) {
           foreach ($article_data as $ad) {
            $html .= '<div class="">
                    <ul class="no-list-style ml-n-3">
                    <li><a href="'.$ad['url'].'">'.$ad['title'].'</a></li>
                    </ul>
                </div>';
            }
        }
        else{
           $html ='<p class="card-text placeholder-glow mt-2">
                <span class="placeholder col-6"></span><br>
                <span class="placeholder col-4"></span><br>
                <span class="placeholder col-8"></span>
            </p>';
        }
        return  $html;
    }
    public function blogRelatedPosts($category, $article_pub_id){
        $article_data = $this->Blog_model->blogRelatedPostsData($category, $article_pub_id);
        $html = '';
        
        if (!empty( $article_data)) {
           foreach ($article_data as $ad) {
            $html .= '<div class="">
                    <ul class="no-list-style ml-n-3">
                    <li><a href="'.$ad['url'].'">'.$ad['title'].'</a></li>
                    </ul>
                </div>';
            }
        }
        else{
           $html ='<p class="card-text placeholder-glow mt-2">
                <span class="placeholder col-6"></span><br>
                <span class="placeholder col-4"></span><br>
                <span class="placeholder col-8"></span>
            </p>';
        }
        return  $html;
    }
    public function addCategory(){

        $check_category = $this->Blog_model->checkCategoryName();
        if ($check_category > 0) {
            $data['status'] = 'error';
            $data['message'] = 'Category already exist!';
        }
        else{
            $this->Blog_model->addCategory();
            $data['status'] = 'success';
            $data['message'] = 'Category successfully added!';

            $message = 'Added new Blog Category';
            $this->User_model->insertActivityLog($message); 
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getCategory(){
        if (!isset($this->session->user_id)) {
            $data['status'] = 'error';
            $data['message'] = "Action not allowed!";
        }
        else{
            $row_no = $this->input->get('page_no');
            // Row per page
            $row_per_page = 10;

            // Row position
            if($row_no != 0){
              $row_no = ($row_no-1) * $row_per_page;
            }

            // All records count
            $all_count = $this->Blog_model->getCategoryCount();

            // Get records
            $result = $this->Blog_model->getCategory($row_per_page, $row_no);

            // Pagination Configuration
            $config['base_url'] = base_url('api/v1/blog/_get_category');
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $all_count;
            $config['per_page'] = $row_per_page;

            // Pagination with bootstrap
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page_no';
            $config['full_tag_open'] = '<ul class="pagination btn-xs">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li class="page-item ">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tagl_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tagl_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item disabled">';
            $config['first_tagl_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tagl_close'] = '</a></li>';
            $config['attributes'] = array('class' => 'page-link');
            $config['next_link'] = 'Next'; // change > to 'Next' link
            $config['prev_link'] = 'Previous'; // change < to 'Previous' link

            // Initialize
            $this->pagination->initialize($config);

            // Initialize $data Array
            $data['pagination'] = $this->pagination->create_links();
            $data['result'] = $result;
            $data['row'] = $row_no;
            $data['count'] = $all_count;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function deleteCategory(){
        $data = $this->Blog_model->deleteCategory();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }

    public function addBlog(){
        $title = $this->input->post('title');
        $url = str_replace(' ','-', strtolower($this->input->post('url')));
        $lead = $this->input->post('lead');
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        $content = $this->input->post('content');

        $check_url = $this->Blog_model->checkBlogURL($url);
        if ($check_url > 0){
            $url = $url.'-'.$this->Blog_model->generateBlogURLExtension();
        }

        if(isset($_POST['article_image']) && !empty($this->input->post('article_image'))) {
            $data = $_POST['article_image'];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $path = 'assets/images/blog/' . time() . '.webp';
            file_put_contents($path, $data);

            $dataArr = array (
                'title'=>$title,
                'url'=>$url,
                'author'=>$this->session->user_id,
                'lead'=>$lead,
                'description'=>$description,
                'category_id'=>$category,
                'content'=>$this->imageClassFluid($content),
                'article_image'=>$path,
                'created_at'=>date('Y-m-d H:i:s'),
            );
            $blog_id = $this->Blog_model->insertNewBlog($dataArr);
            $this->Blog_model->insertTags($blog_id);
            $this->Blog_model->generateBlogPubID($blog_id);
            $response['message'] = 'Article succefully saved! Redirecting to edit page...';
            $response['status'] = 'success';
            $article_data = $this->Blog_model->getArticleID($blog_id);
            $response['url'] = base_url('blog/edit/').$article_data['article_pub_id'];
        }
        else {
            $response['message'] = 'Image is required!';
            $response['status'] = 'error';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function imageClassFluid($html){
        # Add image class img-fluid
        $html = preg_replace('/<img(.*?)\/?>/', '<img class="img-fluid" $1>',$html);
        
        return $html;
    }
    public function updateBlog(){
        $title = $this->input->post('title');
        $url = str_replace(' ','-', strtolower($this->input->post('url')));
        $lead = $this->input->post('lead');
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        $content = $this->input->post('content');
        $article_id = $this->input->post('article_id');

        $check_url = $this->Blog_model->checkBlogURLID($url, $article_id);
        if ($check_url > 0){
            $response['status'] = 'error';
            $response['message'] = 'Duplicate URL. Update your URL and try again!';
        }
        else {
            $dataArr = array (
                'title'=>$title,
                'url'=>$url,
                'lead'=>$lead,
                'description'=>$description,
                'category_id'=>$category,
                'content'=>$this->imageClassFluid($content),
                'updated_at'=>date('Y-m-d H:i:s'),
            );
            $this->Blog_model->updateBlog($dataArr, $article_id);
            // $this->Blog_model->updateTags($blog_id);
            $response['message'] = 'Article succefully Saved!';
            $response['status'] = 'success';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function showBlogList(){
        if (!isset($this->session->user_id)) {
            $data['status'] = 'error';
            $data['message'] = "Action not allowed!";
        }
        else{
            $row_no = $this->input->get('page_no');
            // Row per page
            $row_per_page = 10;

            // Row position
            if($row_no != 0){
              $row_no = ($row_no-1) * $row_per_page;
            }

            // All records count
            $all_count = $this->Blog_model->getBlogListCount();

            // Get records
            $result = $this->Blog_model->getBlogList($row_per_page, $row_no);

            // Pagination Configuration
            $config['base_url'] = base_url('api/v1/blog/_get_list');
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $all_count;
            $config['per_page'] = $row_per_page;

            // Pagination with bootstrap
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page_no';
            $config['full_tag_open'] = '<ul class="pagination btn-xs">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li class="page-item ">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tagl_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tagl_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item disabled">';
            $config['first_tagl_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tagl_close'] = '</a></li>';
            $config['attributes'] = array('class' => 'page-link');
            $config['next_link'] = 'Next'; // change > to 'Next' link
            $config['prev_link'] = 'Previous'; // change < to 'Previous' link

            // Initialize
            $this->pagination->initialize($config);

            // Initialize $data Array
            $data['pagination'] = $this->pagination->create_links();
            $data['result'] = $result;
            $data['row'] = $row_no;
            $data['count'] = $all_count;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function searchBlogArticle(){
        if (!isset($this->session->user_id)) {
            $data['status'] = 'error';
            $data['message'] = "Action not allowed!";
        }
        else{
            $row_no = $this->input->get('page_no');
            // Row per page
            $row_per_page = 10;

            // Row position
            if($row_no != 0){
              $row_no = ($row_no-1) * $row_per_page;
            }

            // All records count
            $all_count = $this->Blog_model->getSearchBlogArticleCount();

            // Get records
            $result = $this->Blog_model->getSearchBlogArticle($row_per_page, $row_no);

            // Pagination Configuration
            $config['base_url'] = base_url('api/v1/blog/_get_list');
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $all_count;
            $config['per_page'] = $row_per_page;

            // Pagination with bootstrap
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page_no';
            $config['full_tag_open'] = '<ul class="pagination btn-xs">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li class="page-item ">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tagl_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tagl_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item disabled">';
            $config['first_tagl_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tagl_close'] = '</a></li>';
            $config['attributes'] = array('class' => 'page-link');
            $config['next_link'] = 'Next'; // change > to 'Next' link
            $config['prev_link'] = 'Previous'; // change < to 'Previous' link

            // Initialize
            $this->pagination->initialize($config);

            // Initialize $data Array
            $data['pagination'] = $this->pagination->create_links();
            $data['result'] = $result;
            $data['row'] = $row_no;
            $data['count'] = $all_count;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function updateArticleStatus(){
        $data = $this->Blog_model->updateArticleStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));

        $message = 'Updated Article ID#'.$this->input->post('id').' status .';
        $this->User_model->insertActivityLog($message); 
    }
    public function removeTag(){
        $data = $this->Blog_model->removeTag();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function addTag(){
        $data = $this->Blog_model->addTag();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function updateImage(){
        $id = $this->input->post('id');

        // $path = "assets/images/blog/"; // upload directory
        // $config['upload_path'] = 'assets/images/blog/';
        // $config['allowed_types'] = 'gif|jpg|png|webp|jpeg';
        // $config['max_size'] = 2000; /* MAX OF 2 MB*/
        // $config['max_width'] = 5000; /* MAX OF 5000 PX*/
        // $config['max_height'] = 5000; /* MAX OF 5000 PX*/
        // $config['encrypt_name'] = true; 
        // $this->load->library('upload', $config);

        // if (!$this->upload->do_upload('article_image')) {
        //     $error = array('error' => $this->upload->display_errors());
        //     $response['status'] = 'error';
        //     $response['message'] = $error['error'];
        // }
        // else {
        //     $data = array('image_metadata' => $this->upload->data());
        //     $path = $path.$data['image_metadata']['file_name'];
        //     $dataArr = array (
        //         'article_image'=>$path,
        //         'updated_at'=>date('Y-m-d H:i:s'),
        //     );
        //     $blog_id = $this->Blog_model->updateBlog($dataArr,$id);
        //     $response['message'] = 'Image succefully Updated!';
        //     $response['status'] = 'success';
        // }
        if(isset($_POST['article_image'])) {
            $data = $_POST['article_image'];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $path = 'assets/images/blog/' . time() . '.webp';
            file_put_contents($path, $data);

            $dataArr = array (
                'article_image'=>$path,
                'updated_at'=>date('Y-m-d H:i:s'),
            );
            $blog_id = $this->Blog_model->updateBlog($dataArr,$id);
            $response['message'] = 'Image succefully Updated!';
            $response['status'] = 'success';
        }
        else{
            $response['status'] = 'error';
            $response['message'] = "Something went wrong. Try again!";
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function deleteArticle(){
        $data = $this->Blog_model->deleteArticle();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getCategoryForPageJS(){
            $category = $this->input->get('category');
            $row_no = $this->input->get('page_no');
            // Row per page
            $row_per_page = 20;

            // Row position
            if($row_no != 0){
              $row_no = ($row_no-1) * $row_per_page;
            }

            // All records count
            $all_count = $this->Blog_model->getCategoryDataForPageCount($category);

            // Get records
            $result = $this->Blog_model->getCategoryDataForPage($row_per_page, $row_no, $category);

            // Pagination Configuration
            $config['base_url'] = base_url('api/v1/article/_get_blog_category');
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $all_count;
            $config['per_page'] = $row_per_page;

            // Pagination with bootstrap
            $config['page_query_string'] = true;
            $config['query_string_segment'] = 'page_no';
            $config['full_tag_open'] = '<ul class="pagination btn-xs">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li class="page-item ">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tagl_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tagl_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item disabled">';
            $config['first_tagl_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tagl_close'] = '</a></li>';
            $config['attributes'] = array('class' => 'page-link');
            $config['next_link'] = 'Next'; // change > to 'Next' link
            $config['prev_link'] = 'Previous'; // change < to 'Previous' link

            // Initialize
            $this->pagination->initialize($config);

            // Initialize $data Array
            $data['pagination'] = $this->pagination->create_links();
            $data['result'] = $result;
            $data['row'] = $row_no;
            $data['count'] = $all_count;
            $data['category'] = str_replace('-',' ', ucwords($category));
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));

    }
    public function getArticleTagForPageJS(){
            $tag = $this->input->get('tag');
            $row_no = $this->input->get('page_no');
            // Row per page
            $row_per_page = 20;

            // Row position
            if($row_no != 0){
              $row_no = ($row_no-1) * $row_per_page;
            }

            // All records count
            $all_count = $this->Blog_model->getArticleTagDataForPageCount($tag);

            // Get records
            $result = $this->Blog_model->getArticleTagDataForPage($row_per_page, $row_no, $tag);

            // Pagination Configuration
            $config['base_url'] = base_url('api/v1/article/_get_blog_category');
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $all_count;
            $config['per_page'] = $row_per_page;

            // Pagination with bootstrap
            $config['page_query_string'] = true;
            $config['query_string_segment'] = 'page_no';
            $config['full_tag_open'] = '<ul class="pagination btn-xs">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li class="page-item ">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tagl_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tagl_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item disabled">';
            $config['first_tagl_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tagl_close'] = '</a></li>';
            $config['attributes'] = array('class' => 'page-link');
            $config['next_link'] = 'Next'; // change > to 'Next' link
            $config['prev_link'] = 'Previous'; // change < to 'Previous' link

            // Initialize
            $this->pagination->initialize($config);

            // Initialize $data Array
            $data['pagination'] = $this->pagination->create_links();
            $data['result'] = $result;
            $data['row'] = $row_no;
            $data['count'] = $all_count;
            $data['tag'] = str_replace('-',' ', ucwords($tag));
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));

    }
    public function checkArticle(){
        $data = $this->Blog_model->checkArticle();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function uploadImage(){
        $id = $this->input->post('id');
        if(isset($_POST['more_image'])) {
            $data = $_POST['more_image'];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $path = 'assets/images/blog/' . time() . '.webp';
            file_put_contents($path, $data);

            $dataArr = array (
                'image'=>$path,
                'user_id'=>$this->session->user_id,
                'created_at'=>date('Y-m-d H:i:s'),
            );
            $blog_id = $this->Blog_model->uploadImage($dataArr,$id);
            $response['message'] = 'Image succefully Uploaded!';
            $response['status'] = 'success';
        }
        else{
            $response['status'] = 'error';
            $response['message'] = "Something went wrong. Try again!";
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function getImages(){
        if (!isset($this->session->user_id)) {
            $data['status'] = 'error';
            $data['message'] = "Action not allowed!";
        }
        else{
            $row_no = $this->input->get('page_no');
            // Row per page
            $row_per_page = 10;

            // Row position
            if($row_no != 0){
              $row_no = ($row_no-1) * $row_per_page;
            }

            // All records count
            $all_count = $this->Blog_model->getImageListCount();

            // Get records
            $result = $this->Blog_model->getImageList($row_per_page, $row_no);

            // Pagination Configuration
            $config['base_url'] = base_url('api/v1/blog/_get_list');
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $all_count;
            $config['per_page'] = $row_per_page;

            // Pagination with bootstrap
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page_no';
            $config['full_tag_open'] = '<ul class="pagination btn-xs">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li class="page-item ">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tagl_close'] = '</a></li>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tagl_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item disabled">';
            $config['first_tagl_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tagl_close'] = '</a></li>';
            $config['attributes'] = array('class' => 'page-link');
            $config['next_link'] = 'Next'; // change > to 'Next' link
            $config['prev_link'] = 'Previous'; // change < to 'Previous' link

            // Initialize
            $this->pagination->initialize($config);

            // Initialize $data Array
            $data['pagination'] = $this->pagination->create_links();
            $data['result'] = $result;
            $data['row'] = $row_no;
            $data['count'] = $all_count;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}