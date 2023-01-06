<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Site_settings_model');
    }
    public function index(){
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'Page not Found';
        $data['description'] = 'Error 404 Page not Found';
        $data['canonical_url'] = base_url();
        $data['state'] = "error404";
        $data['url_param'] = "";
    	$this->load->view('home/header', $data);
    	$this->load->view('home/nav');
    	$this->load->view('errors/error_404');
    	$this->load->view('home/footer');
    }
   
   
}
