<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Sitemap extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	public function index(){
		header("Content-Type: text/xml;charset=iso-8859-1");
		$this->load->view('sitemap/sitemap_view');
	}
}