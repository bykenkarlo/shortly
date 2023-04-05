<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Page extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->library('user_agent');
        $this->load->model('Site_settings_model');
        $this->load->model('Csrf_model');
        $this->load->model('User_model');
        $this->load->model('Blog_model');

    }
    public function about(){
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'About Us';
        $data['description'] = 'Shortly is a Short URL, Link Shortener & Free URL Customization';
        $data['canonical_url'] = base_url('about');
        $data['state'] = "about";
        $data['url_param'] = "";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
    	$this->load->view('home/header', $data);
    	$this->load->view('home/nav');
    	$this->load->view('pages/about');
    	$this->load->view('home/footer');
    }
    public function privacy(){
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'Privacy Policy';
        $data['description'] = 'By using the Shortly website, you consent to the data practices described in this statement.';
        $data['canonical_url'] = base_url('privacy');
        $data['url_param'] = "";
        $data['state'] = "privacy";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
    	$this->load->view('home/header', $data);
    	$this->load->view('home/nav');
    	$this->load->view('pages/privacy');
    	$this->load->view('home/footer');
    }
    public function terms(){
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'Terms and Conditions';
        $data['description'] = 'By using the Shortly website, you consent to the data practices described in this statement.';
        $data['canonical_url'] = base_url('privacy-terms');
        $data['url_param'] = "";
        $data['state'] = "terms";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
    	$this->load->view('home/header', $data);
    	$this->load->view('home/nav');
    	$this->load->view('pages/terms');
    	$this->load->view('home/footer');
    }
    public function userLogin(){
        if(isset($_COOKIE['remember_login'])) {
            $userCookieData = $this->User_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
            $last_url = $this->input->get('return');
            if (isset($userCookieData)) {
                $this->session->set_userdata('user_id', $userCookieData['user_id']);
                $this->session->set_userdata($userCookieData['user_type'], $userCookieData['user_type']);
                $this->session->set_userdata('username', $userCookieData['username']);

                $message = 'Logged in using remember token cookie.';
                $this->User_model->insertActivityLog($message); 


                if ($last_url != '') {
                    header('location:'.base_url( ).$last_url);
                }
                else{
                    header('location:'.base_url('account/dashboard'));
                }

            }
            else{
                unset($_COOKIE['remember_login']); 
                setcookie('remember_login', '', time() - 3600, '/');
                $session = array(
                    'user_id', 
                    'username',
                );
                $this->session->unset_userdata($session);
                header('location:'.base_url('login?return=').uri_string());
            }
        }
        else if (!isset($this->session->user_id)) {
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['social_media'] = $this->Site_settings_model->getSocialMedias();
            $data['title'] = 'Login';
            $data['description'] = 'Login your account.';
            $data['canonical_url'] = base_url('login');
            $data['url_param'] = "";
            $data['state'] = "login";
            $data['login_token'] = base64_encode( openssl_random_pseudo_bytes(32)); /* generated token */
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $this->load->view('account/header', $data);
            $this->load->view('home/nav');
            $this->load->view('shortener/login');
            $this->load->view('home/footer');
        }
        else{
           header('location:'.base_url('account/dashboard')); 
        }
    }
    public function login(){
        if(isset($_COOKIE['remember_login'])) {
            $userCookieData = $this->User_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
            $last_url = $this->input->get('return');
            if (isset($userCookieData)) {
                $this->session->set_userdata('user_id', $userCookieData['user_id']);
                $this->session->set_userdata($userCookieData['user_type'], $userCookieData['user_type']);
                $this->session->set_userdata('username', $userCookieData['username']);

                $message = 'Logged in using remember token cookie.';
                $this->User_model->insertActivityLog($message); 


                if ($last_url != '') {
                    header('location:'.base_url( ).$last_url);
                }
                else{
                    header('location:'.base_url('account/dashboard'));
                }

            }
            else{
                unset($_COOKIE['remember_login']); 
                setcookie('remember_login', '', time() - 3600, '/');
                $session = array(
                    'user_id', 
                    'username',
                );
                $this->session->unset_userdata($session);
                header('location:'.base_url('login?return=').uri_string());
            }
        }
        else if (!isset($this->session->user_id)) {
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['social_media'] = $this->Site_settings_model->getSocialMedias();
            $data['title'] = 'Login';
            $data['description'] = 'Login your account.';
            $data['canonical_url'] = base_url('login');
            $data['url_param'] = "";
            $data['state'] = "login";
            $data['login_token'] = base64_encode( openssl_random_pseudo_bytes(32)); /* generated token */
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $this->load->view('account/header', $data);
            $this->load->view('home/nav');
            $this->load->view('account/login');
            $this->load->view('home/footer');
        }
        else{
           header('location:'.base_url('account/dashboard')); 
        }
    }
    public function dashboard(){
        if (isset($this->session->user_id)) {
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'Dashboard';
        $data['description'] = 'Login your account.';
        $data['canonical_url'] = base_url('dashboard');
        $data['url_param'] = "";
        $data['state'] = "dashboard";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
        $data['user_data'] = $this->User_model->getUserData(); 
    	$this->load->view('account/header', $data);
    	$this->load->view('account/nav');
    	$this->load->view('account/dashboard');
    	$this->load->view('account/footer');
        }
        else{
            header('location:'.base_url('login?return=').uri_string());
        }
    }
    public function urlList(){
        if (isset($this->session->user_id)) {
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'URL List';
        $data['description'] = 'URL lists';
        $data['canonical_url'] = base_url('url-list');
        $data['url_param'] = "";
        $data['state'] = "url_list";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
        $data['user_data'] = $this->User_model->getUserData(); 
    	$this->load->view('account/header', $data);
    	$this->load->view('account/nav');
    	$this->load->view('account/url_list');
    	$this->load->view('account/footer');
        }
        else{
            header('location:'.base_url('login?return=').uri_string());
        }
    }
    public function usersList(){
        if (isset($this->session->user_id)) {
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'Users List';
        $data['description'] = 'Users Lists';
        $data['canonical_url'] = base_url('users-list');
        $data['url_param'] = "";
        $data['state'] = "users_list";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
        $data['user_data'] = $this->User_model->getUserData(); 
    	$this->load->view('account/header', $data);
    	$this->load->view('account/nav');
    	$this->load->view('account/users_list');
    	$this->load->view('account/footer');
        }
        else{
            header('location:'.base_url('login?return=').uri_string());
        }
    }
    public function article($url){
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['article_data'] = $this->Blog_model->getArticleDataURL($url);
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        if (!empty($data['article_data']['title']) && $data['article_data']['status'] == 'published') {
            $data['canonical_url'] = $data['article_data']['url'];
            $data['state'] = 'article';
            $data['url_param'] = '';
            $data['title'] = $data['article_data']['title'];
            $data['description'] = $data['article_data']['description'];
            $data['nonce'] = $this->Site_settings_model->generateNonce();
            $this->load->view('article/header', $data);
            $this->load->view('article/navbar');
            $this->load->view('article/article');
            $this->load->view('article/footer');
        }
        else{
            $this->Site_settings_model->error404();
        }
    }
    public function category($category){
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['nonce'] = $this->Site_settings_model->generateNonce();
        $data['title'] = 'Category '.ucwords($category);
        $data['category'] = ucwords($category);
        $data['description'] = $category. '';
        $data['canonical_url'] = base_url('category/').$category;
        $data['state'] = 'blog_category';
        $data['url_param'] = '';
        $this->load->view('home/header', $data);
        $this->load->view('home/nav');
        $this->load->view('article/category');
        $this->load->view('article/footer');
    }
    public function tags($tags){
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['nonce'] = $this->Site_settings_model->generateNonce();
        $data['title'] = 'Tag '.ucwords(str_replace('-',' ',$tags));
        $data['tags'] = ucwords($tags);
        $data['description'] = $tags. '';
        $data['canonical_url'] = base_url('tags/').$tags;
        $data['state'] = 'blog_tags';
        $data['url_param'] = '';
        $this->load->view('home/header', $data);
        $this->load->view('home/nav');
        $this->load->view('article/tags');
        $this->load->view('article/footer');
    }
    public function draft($url){
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['article_data'] = $this->Blog_model->getArticleDataURL($url);
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        if (!empty($data['article_data']['title']) && $data['article_data']['status'] == 'draft') {
            $data['canonical_url'] = $data['article_data']['url'];
            $data['state'] = 'article';
            $data['url_param'] = '';
            $data['title'] = $data['article_data']['title'];
            $data['description'] = $data['article_data']['description'];
            $data['nonce'] = $this->Site_settings_model->generateNonce();
            $this->load->view('article/header', $data);
            $this->load->view('article/navbar');
            $this->load->view('article/article');
            $this->load->view('article/footer');
        }
        else{
            $this->Site_settings_model->error404();
        }
    }
    public function blog(){
        $data['recent_blog_data'] = $this->Blog_model->getRecentArticleDataForPage();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['blog_data'] = $this->Blog_model->getArticleDataForPage();
        $data['user_data'] = $this->User_model->getUserData(); 
        $data['canonical_url'] = base_url('blog');
        $data['description'] = 'Learn more about Shorrtly for Link shortener, SHort URLs, Online Lending trivia, How-to, tips articles';
        $data['title'] = 'Blog';
        $data['state'] = 'blog';
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
        $data['url_param'] = "";
        $this->load->view('home/header', $data);
        $this->load->view('home/nav');
        $this->load->view('home/blog');
        $this->load->view('home/footer');
    }
    public function blogList(){
        if (isset($this->session->user_id)) {
            $data['user_data'] = $this->User_model->getUserData(); 
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['canonical_url'] = base_url('account/blog');
            $data['nonce'] = $this->Site_settings_model->generateNonce();
            $data['description'] = '';
            $data['title'] = 'Blog List';
            $data['state'] = 'blog_list';
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $data['url_param'] = "";
            $this->load->view('account/header', $data);
            $this->load->view('account/nav');
            $this->load->view('account/blog_list');
            $this->load->view('account/footer');
        }
        else{
           header('location:'.base_url('login?return=').uri_string());
        }
   }
   public function newBlog(){
        if (isset($this->session->user_id)) {
            $data['user_data'] = $this->User_model->getUserData(); 
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['canonical_url'] = base_url('account/blog/new');
            $data['nonce'] = $this->Site_settings_model->generateNonce();
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $data['blog_category'] = $this->Blog_model->getCategorySelect();
            $data['description'] = '';
            $data['title'] = 'New Blog';
            $data['state'] = 'new_blog';
            $data['url_param'] = "";
            $this->load->view('account/header', $data);
            $this->load->view('account/nav');
            $this->load->view('account/add_blog');
            $this->load->view('account/footer');
         }
        else{
            header('location:'.base_url('login?return=').uri_string());
        }
    }
    public function editBlog($article_pub_id){
        if (isset($this->session->user_id)) {
            $data['user_data'] = $this->User_model->getUserData(); 
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['canonical_url'] = base_url('account/blog/edit/'.$article_pub_id);
            $data['nonce'] = $this->Site_settings_model->generateNonce();
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $data['article_data'] = $this->Blog_model->getArticleDataID($article_pub_id);
            $data['blog_category'] = $this->Blog_model->getCategorySelect();
            $data['description'] = '';
            $data['title'] = 'Edit Blog';
            $data['state'] = 'edit_blog';
            $data['url_param'] = "";
            $this->load->view('account/header', $data);
            $this->load->view('account/nav');
            $this->load->view('account/edit_blog');
            $this->load->view('account/footer');
         }
        else{
            header('location:'.base_url('login?return=').uri_string());
        }
    }
    public function newWebsiteVisits(){
		$data = $this->User_model->newWebsiteVisits();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
    public function logout(){
        unset($_COOKIE['remember_login']); 
        setcookie('remember_login', '', time() - 3600, '/');
        $session = array(
            'user_id', 
            'username',
            'admin',
            'sys_admin',
            'staff',
            'super_staff',
            'borrower',
        );
        $this->session->unset_userdata($session);
        $this->session->sess_destroy();
        header('location:'.base_url('login'));
    }
    
}