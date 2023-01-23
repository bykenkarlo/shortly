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
        $data['canonical_url'] = base_url('terms');
        $data['url_param'] = "";
        $data['state'] = "terms";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
    	$this->load->view('home/header', $data);
    	$this->load->view('home/nav');
    	$this->load->view('pages/terms');
    	$this->load->view('home/footer');
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