<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Account extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Account_model');
        $this->load->model('Site_settings_model');
        $this->load->model('User_model');
        $this->load->model('Csrf_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }
    public function getURLList() {
		$row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        // All records count
        $all_count = $this->Account_model->getURLListCount();
        // Get records
        $result = $this->Account_model->getURLList($row_per_page, $row_no);
        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/loan/_get_list');
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
    public function generateSecretKey(){
        $data = $this->User_model->generateSecretKey();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function accountRegistration(){
        $email_address = $this->input->post('email_address');
        $email_token = '';
        if(empty($email_address)){
            $response = $this->User_model->accountRegistration('');
        }
        else if(!empty($email_address)){
            $this->form_validation->set_rules('email_address', 'Email Address', 'valid_email|trim|is_unique[users_tbl.email_address]',
                array(
                    'is_unique'     => 'This %s already exists.',
                )
            );
            if ($this->form_validation->run() == FALSE) {
                $response['status'] = 'error';
                $response['message'] = $this->form_validation->error_array();
            }
            else{
                $email_token = $this->User_model->generateEmailToken();
                $response = $this->User_model->accountRegistration($email_token);
                $this->sendVerificationEnail($email_token, $email_address);
            }

            // send verification code

        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
       }
  
       public function sendVerificationEnail($email_token, $email_address){
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['priority']= '1';
            // $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'shortly.at ';
            $config['smtp_crypto'] = 'tls';
            $config['smtp_port'] = '465';
            $config['smtp_user']  = 'info@shortly.at';
            $config['smtp_pass'] = '@Kenkarlo-01';
            $config['newline'] = "\r\n";
            $config['validation'] = FALSE;
            $config['smtp_timeout']='30';

            $subject = 'Email Verification!';
            
            $data['verification_url'] = base_url('verify/').$email_token;
            $data['header_image'] = base_url().'assets/images/logo/hh-logo.png';
            $data['header_image_url'] = base_url().'?utm_source=shortly&utm_medium=email_verification&utm_campaign=email';

            $this->email->initialize($config);
            $this->email->from('info@shortly.at', 'Shortly');
            $this->email->reply_to('info@shortly.at', 'Shortly');
            $this->email->to($email_address); 
            $this->email->subject($subject);
            $body = $this->load->view('email/email_verification', $data, TRUE);
            $this->email->message($body);
            $this->email->send();
        }
        public function saveEmailAddress(){
            $email_address = $this->input->post('email_address');
            $this->form_validation->set_rules('email_address', 'Email Address', 'valid_email|trim|is_unique[users_tbl.email_address]',
                array(
                    'is_unique'     => 'This %s already exists.',
                )
            );
            if ($this->form_validation->run() == FALSE) {
                $response['status'] = 'error';
                $response['message'] = $this->form_validation->error_array();
            }
            else{
                $email_token = $this->User_model->generateEmailToken();
                $this->User_model->saveEmailAddress($email_token);
                $this->sendVerificationEnail($email_token, $email_address);
                $response['status'] = 'success';
                $response['message'] = "Email sent for verification!";
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
       }
       public function getUserList() {
		$row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        // All records count
        $all_count = $this->Account_model->getUserListCount();
        // Get records
        $result = $this->Account_model->getUserList($row_per_page, $row_no);
        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/loan/_get_list');
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
}