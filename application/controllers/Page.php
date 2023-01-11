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
    public function newWebsiteVisits(){
		$data = $this->User_model->newWebsiteVisits();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
}