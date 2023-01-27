<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Sitemap extends CI_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('Blog_model');
	}
	public function index(){
		header("Content-Type: text/xml;charset=iso-8859-1");
		$data['articles'] = $this->Blog_model->getArticleForSitemap();
		$this->load->view('sitemap/sitemap_view', $data);
	}
}