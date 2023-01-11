<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Statistics extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->model('Statistics_model');
    }
    public function getWebsiteStatsChart(){
    	$data = $this->Statistics_model->getWebsiteStatsChart();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getWebsiteStats(){
    	$data = $this->Statistics_model->getWebsiteStats();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getLendingBussinessStats(){
        $data = $this->Statistics_model->getLendingBussinessStats();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }

}