<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class App extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Site_settings_model');
        $this->load->model('Csrf_model');
        $this->load->library('user_agent');
    }
    public function index(){
        $this->output->cache(2); // cache for xxx
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'index';
        $data['description'] = 'A FREE URL Shortener Tool with Premium Features without account registration.';
        $data['canonical_url'] = base_url();
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
        $data['state'] = "index";
        $data['url_param'] = "";
        $this->output->delete_cache('application/cache/'); // delete cache url
    	$this->load->view('home/header', $data);
    	$this->load->view('home/nav');
    	$this->load->view('home/index');
    	$this->load->view('home/footer');
    }
    public function getCsrfData() { 
        $data = $this->Csrf_model->getCsrfData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
   
}
