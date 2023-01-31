<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');
require FCPATH.'vendor/autoload.php';
use ImageKit\ImageKit;  
use ipinfo\ipinfo\IPinfo;

class Shortener extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->model('Shortener_model');
        $this->load->model('Site_settings_model');
        $this->load->model('Csrf_model');
        $this->load->model('User_model');
    }
    public function processUrl() {
        $data = $this->Shortener_model->processUrl();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function accessLongURL($url_param){
        $data = $this->Shortener_model->accessLongURL($url_param);
        if(!empty($data)){
            $click_id = $this->Shortener_model->recordUserClick($url_param);
            $this->User_model->newWebsiteVisits(); // insert new visit
            header('Location: '.$data);
        }
        else{
            $this->Site_settings_model->error404();
        }
    }
    public function checkURLStat($param){
        $url_data = $this->Shortener_model->checkURLData($param);
        if($url_data > 0){
            $data['siteSetting'] = $this->Site_settings_model->siteSettings();
            $data['social_media'] = $this->Site_settings_model->getSocialMedias();
            $data['title'] = 'Check your URL Statistics';
            $data['description'] = 'this is the description';
            $data['canonical_url'] = base_url();
            $data['csrf_data'] = $this->Csrf_model->getCsrfData();
            $data['state'] = "statistics";
            
            $data['url_param'] = $param;
            $data['url_data'] =  $this->Shortener_model->getURLDataByURLParam($param);
            $this->load->view('home/header', $data);
            $this->load->view('home/nav');
            $this->load->view('shortener/statistics');
            $this->load->view('home/footer');
        }
        else{
            $this->Site_settings_model->error404();
        }
    }
    public function getURLData(){
        $data = $this->Shortener_model->getURLData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getClickStat(){
        $data = $this->Shortener_model->getClickStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getReferrerStat(){
        $data = $this->Shortener_model->getReferrerStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getBrowserStat(){
        $data = $this->Shortener_model->getBrowserStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getPlatformStat(){
        $data = $this->Shortener_model->getPlatformStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getLocationStat(){
        $data = $this->Shortener_model->getLocationStat();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function uploadCustomLogo(){
        if(isset($_FILES['logo_img'])) {
            $url_param = $this->input->post('url_param');
            $data = $_POST['logo_img'];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $img_name =  time() . '.webp';
            $path = 'assets/images/uploaded/' .$img_name;
            file_put_contents($path, $data);
            
            if (strpos(base_url(), 'localhost') !== false || strpos(base_url(), 'test') !== false ) { 
                $final_img = base_url().$path;
            }
            else{
                $this->load->library('image_kit');
                $auth = $this->image_kit->authKeys(); 
                $imageKit = new ImageKit(
                    $auth['public_key'],
                    $auth['private_key'],
                    $auth['end_point_url']
                );
                $uploadFile = $imageKit->uploadFile([
                    'file' => base_url().$path,
                    'fileName' => $img_name
                ]);   
                $final_img = $uploadFile->result->url;
            }
            $dataArr = array (
                'url_param'=>$url_param,
                'image'=>$final_img,
            );
            $this->Shortener_model->uploadCustomLogo($dataArr);
            $response['message'] = 'Logo succefully Uploaded!';
            $response['status'] = 'success';
            $response['attribute'] = array('url_param'=>$url_param, 'image'=>$final_img);
        }
        else{
            $response['status'] = 'error';
            $response['message'] = "Image is required!";
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function imagekit(){
        $data = $this->Shortener_model->imagekit();
    }
    public function getEmailAddress(){
        $data = $this->Shortener_model->getEmailAddress();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function customizeUrl(){
        $data = $this->Shortener_model->customizeUrl();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function changeStatus(){
        $data = $this->Shortener_model->changeStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
}