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
    public function getSiteVisits(){
    	$data = $this->Statistics_model->getSiteVisits();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getLinkCreated(){
    	$data = $this->Statistics_model->getLinkCreated();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getLocationChartStat(){
    	$data = $this->Statistics_model->getLocationChartStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getBrowserChartStat(){
    	$data = $this->Statistics_model->getBrowserChartStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getPlatformChartStat(){
    	$data = $this->Statistics_model->getPlatformChartStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getRefererChartStat(){
    	$data = $this->Statistics_model->getRefererChartStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getMostViewedStat(){
    	$data = $this->Statistics_model->getMostViewedStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getLinkClick(){
    	$data = $this->Statistics_model->getLinkClick();
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