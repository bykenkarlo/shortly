<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Ads extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Ads_model');
        $this->load->model('Shortener_model');
        $this->load->library('pagination');
        $this->load->library('user_agent');
    }
    public function redirectAdsAfterClick($ad_id) {
        $data = $this->Ads_model->getAdDataByAdID($ad_id);
        $location = $this->Shortener_model->getLocationData();
		$click_id = $this->Ads_model->generateClickID();
        $this->Ads_model->recordClick($ad_id, $location, $click_id );
        header('Location:'. $data['redirect_url']);
    }
    public function save() {
        $response = $this->Ads_model->save();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function getList() {
        $row_no = $this->input->get('page_no');
        // Row per page
        $row_num = $this->input->get('row_num');
        if($row_num == 'all'){
            $row_per_page = 500;    
        }
        else {
            $row_per_page = 20;
        }
        
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        // All records count
        $all_count = $this->Ads_model->getAdsListCount();
        // Get records
        $result = $this->Ads_model->getAdsList($row_per_page, $row_no);
        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/ad/_get_list');
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
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#curr">';
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
        $data['result'] = $this->security->xss_clean($result); 
        $data['row'] = $row_no;
        $data['count'] = $all_count;
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function changeStatus() {
        $response = $this->Ads_model->changeStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function delete() {
        $response = $this->Ads_model->delete();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
}