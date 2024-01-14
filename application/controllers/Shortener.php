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
        $this->load->library('pagination');
        $this->load->library('google_app_api');
        $this->load->model('Shortener_model');
        $this->load->model('Site_settings_model');
        $this->load->model('Csrf_model');
        $this->load->model('User_model');
        $this->load->model('GoogleApi_model');
        $this->load->model('Ads_model');
    }
    public function processUrl() {
        $long_url = $this->input->post('long_url');
        $malicious_url = $this->Shortener_model->checkBlocklistURLs($long_url, 'Malicious URL');
        $shortener_url = $this->Shortener_model->checkBlocklistURLs($long_url, 'URL Shortener');
        $spam_url = $this->Shortener_model->checkBlocklistURLs($long_url, 'Spam URL');
        $phishing_url = $this->Shortener_model->checkBlocklistURLs($long_url, 'Phishing URL');

        // $check_url_shortener = $this->Shortener_model->checkURLShortenerSites();
        // $check_spam_url = $this->Shortener_model->checkSpamURL();
        if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $long_url)) {
            $response['status'] = 'error';
            $response['title'] = "Error";
            $response['message'] = "Please enter a correct URL!";
        }
        else if(!empty($malicious_url)){
            $response['status'] = 'error';
            $response['title'] = "Blocked URL!";
            $response['message'] = "This URL is was reported and considered as Malicious, abusive and is blocklisted! Contact us if you think this is a mistake!";
        }
        else if(!empty($shortener_url)){
            $response['status'] = 'error';
            $response['title'] = "Short URL Detected!";
            $response['message'] = "The URL uses a URL Shortener! Read our Terms for more information!";
        }
        else if(!empty($spam_url)){
            $response['status'] = 'error';
            $response['title'] = "Spam URL Detected!";
            $response['message'] = "The URL is considered as Spam! Contact us if you think this is a mistake!";
        }
        else if(!empty($phishing_url)){
            $response['status'] = 'error';
            $response['title'] = "Phishing URL Detected!";
            $response['message'] = "The URL is considered as Phishing and Malicious! Contact us if you think this is a mistake!";
        }
        else{
            $response = $this->Shortener_model->processUrl();
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function accessLongURL($url_param){
        $data_url = $this->Shortener_model->accessLongURL($url_param);
        $check_block_url = $this->Shortener_model->checkBlockURL($url_param);
        if(!empty($data_url) && $check_block_url <= 0){
            $click_id = $this->Shortener_model->recordUserClick($url_param);
            $this->User_model->newWebsiteVisits(); // insert new visit
            // header('Location: '.$data_url);

            $data['url'] = $data_url;
            $data['ad_data'] =  $this->Ads_model->showAdData('banner');
            $this->load->view('shortener/redirect', $data);
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
            $data['ad_data'] =  $this->Ads_model->showAdData('button');
            $data['blocked_status'] = $this->Shortener_model->checkBlockStatus($param);
            $this->load->view('home/header', $data);
            $this->load->view('home/nav');
            $this->load->view('shortener/statistics');
            $this->load->view('home/footer');
        }
        else{
            $this->Site_settings_model->error404();
        }
    }
    public function accountDashboard(){ // user account's dashboard
        if(isset($this->session->secret_key)){
            $secret_key = $this->session->secret_key;
            $user_data = $this->User_model->checkAccountSecretKey($secret_key);
            if(!empty($user_data)){
                $data['siteSetting'] = $this->Site_settings_model->siteSettings();
                $data['social_media'] = $this->Site_settings_model->getSocialMedias();
                $data['title'] = 'Account Link Management';
                $data['description'] = 'Account dashboard where you can manage your multiple URLs';
                $data['canonical_url'] = base_url('logged/').$secret_key;
                $data['url_param'] = "";
                $data['user_data'] = $user_data;
                $data['state'] = "account_dashboard";
                $data['csrf_data'] = $this->Csrf_model->getCsrfData();
                $this->load->view('shortener/header', $data);
                $this->load->view('shortener/nav');
                $this->load->view('shortener/account_dashboard');
                $this->load->view('shortener/footer');
            }
            else{
                header('Location: '.base_url('login'));
            }
        }
        else{
            $this->Site_settings_model->error404();
        }
    }
    public function accountBio(){ // user account's dashboard
        if(isset($this->session->secret_key)){
            $secret_key = $this->session->secret_key;
            $user_data = $this->User_model->checkAccountSecretKey($secret_key);
            if(!empty($user_data)){
                $data['siteSetting'] = $this->Site_settings_model->siteSettings();
                $data['social_media'] = $this->Site_settings_model->getSocialMedias();
                $data['title'] = 'Link in Bio';
                $data['description'] = 'Link in Bio - a place where you can you link all your social media accounts in one link.';
                $data['canonical_url'] = base_url('logged/bio').$secret_key;
                $data['url_param'] = "";
                $data['user_data'] = $user_data;
                $data['state'] = "bio";
                $data['csrf_data'] = $this->Csrf_model->getCsrfData();
                $this->load->view('shortener/header', $data);
                $this->load->view('shortener/nav');
                $this->load->view('shortener/account_bio');
                $this->load->view('shortener/footer');
            }
            else{
                header('Location: '.base_url('login'));
            }
        }
        else{
            $this->Site_settings_model->error404();
        }
    }
    public function accountSettings(){
        if(isset($this->session->secret_key)){
            $secret_key = $this->session->secret_key;
            $user_data = $this->User_model->checkAccountSecretKey($secret_key);
            if(!empty($user_data)){
                $data['siteSetting'] = $this->Site_settings_model->siteSettings();
                $data['social_media'] = $this->Site_settings_model->getSocialMedias();
                $data['title'] = 'Account Settings';
                $data['description'] = 'Account settings where you can change your password, update your email and etc.';
                $data['canonical_url'] = base_url('logged/').$secret_key;
                $data['url_param'] = "";
                $data['user_data'] = $user_data;
                $data['state'] = "settings";
                $data['csrf_data'] = $this->Csrf_model->getCsrfData();
                $this->load->view('shortener/header', $data);
                $this->load->view('shortener/nav');
                $this->load->view('shortener/settings');
                $this->load->view('shortener/footer');
            }
            else{
                header('Location: '.base_url('login'));
            }
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
        $row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        $location_stat =  $this->Shortener_model->getLocationStat($row_per_page, $row_no);
        // All records count
        $all_count = $location_stat['total_count'];
        // Get records
        $result = $location_stat['country_statistics'];
        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/shortener/_get_location_stats');
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
        $config['next_link'] = '›'; // change > to 'Next' link
        $config['prev_link'] = '‹'; // change < to 'Previous' link
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        // Initialize
        $this->pagination->initialize($config);
        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $this->security->xss_clean($result); 
        $data['row'] = $row_no;
        $data['count'] = $all_count;
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
    public function imagekit()
    {
        $data = $this->Shortener_model->imagekit();
    }
    public function getEmailAddress()
    {
        $data = $this->Shortener_model->getEmailAddress();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function customizeUrl()
    {
        $data = $this->Shortener_model->customizeUrl();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function changeStatus()
    {
        $data = $this->Shortener_model->changeStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getAccountURLs()
    {
        $data = $this->User_model->getAccountURLs();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getAccountURLData()
    {
        $data = $this->Shortener_model->getAccountURLData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getAccountURLDataV2()
    {
        $data = $this->Shortener_model->getAccountURLDataV2();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function saveCustomURL()
    {
        $data = $this->Shortener_model->saveCustomURL();
        $clean_data = $this->security->xss_clean( $data);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$clean_data)));
    }
    public function accountNewShortURL()
    {
        if(isset($this->session->secret_key))
        {
			$long_url = $this->input->post('redirect_url');
			$title = $this->input->post('title');
			$custom_link = $this->input->post('custom_link');
			$check_url_param = $this->db->WHERE('short_url', $custom_link)->GET('shortened_url_tbl')->num_rows();
            $malicious_url = $this->Shortener_model->checkBlocklistURLs($long_url, 'Malicious URL');
            $shortener_url = $this->Shortener_model->checkBlocklistURLs($long_url, 'URL Shortener');
            $spam_url = $this->Shortener_model->checkBlocklistURLs($long_url, 'Spam URL');
            $phishing_url = $this->Shortener_model->checkBlocklistURLs($long_url, 'Phishing URL');
    
			if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $long_url)) {
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Please enter a correct URL!";
			}
            else if(!empty($malicious_url)){
                $response['status'] = 'error';
                $response['title'] = "Blocked URL!";
				$response['short_url'] = "";
                $response['message'] = "This URL is was reported and considered as Malicious, abusive and is blocklisted! Contact us if you think this is a mistake!";
            }
            else if(!empty($shortener_url)){
                $response['status'] = 'error';
                $response['title'] = "Short URL Detected!";
				$response['short_url'] = "";
                $response['message'] = "The URL uses a URL Shortener! Read our Terms for more information!";
            }
            else if(!empty($spam_url)){
                $response['status'] = 'error';
				$response['short_url'] = "";
                $response['title'] = "Spam URL Detected!";
                $response['message'] = "The URL is considered as Spam! Contact us if you think this is a mistake!";
            }
            else if(!empty($phishing_url)){
                $response['status'] = 'error';
				$response['short_url'] = "";
                $response['title'] = "Phishing URL Detected!";
                $response['message'] = "The URL is considered as Phishing and Malicious! Contact us if you think this is a mistake!";
            }
			else if($check_url_param > 0){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL already exist!";
			}
			else if(!empty($custom_link) && strlen($custom_link) < 4 ){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL should be at least 4 characters";
			}
			else if(!empty($custom_link) && strlen($custom_link) > 30){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL should not be more than 30 characters";
			}
           
			else if(!empty($long_url)) {
				$short_url = ($custom_link!=='')?$custom_link:$this->Shortener_model->shortURLGenerator();
				$data_arr = array(
					'long_url'=>$long_url,
					'short_url'=>str_replace(' ','-',$short_url),
					'status'=>'active',
					'created_at'=>date('Y-m-d H:i:s')
				);
				$data_arr2 = array(
					'secret_key'=>$this->session->secret_key,
					'title'=>($title!=='')?$title:'',
					'url_param'=>str_replace(' ','-',$short_url),
					'status'=>'active',
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->Shortener_model->accountNewShortURL($data_arr, $data_arr2);

				$response['status'] = 'success';
				$response['message'] = "Here's your short URL ".base_url().$short_url.".";
				$response['attribute'] = array('param'=>$short_url,'url'=>base_url().$short_url,'uuu'=> $malicious_url);
			}
		}
		else
        {
			$response['status'] = 'error';
			$response['short_url'] = "";
			$response['message'] = "Something went wrong! Refresh the page and try again!";
		}
        // $data = $this->Shortener_model->newShortURL();

        $clean_data = $this->security->xss_clean($response);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$clean_data)));
    }
    public function getAccountData()
    {
        $data = $this->User_model->getAccountData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function verifyEmailAddress($token)
    {
        $checkUser = $this->User_model->verifyEmailAddress($token);
        if(!empty($checkUser)){
           $this->session->set_userdata('secret_key', $checkUser['secret_key']);
           $this->User_model->updateEmailVerification();
           header('Location: '.base_url('logged/dashboard?verify=email_verified'));
        }
        else{
           header('Location: '.base_url('?verify=invalid'));
        }
    }
    public function deleteURL()
    {
        $data = $this->Shortener_model->deleteURL();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function blocklistURL() 
    {
        $data = $this->Shortener_model->blocklistURL();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function unblocklistURL() 
    {
        $data = $this->Shortener_model->unblocklistURL();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getBlocklistURL() 
    {
		$row_no = $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;
        // Row position
        if($row_no != 0){
            $row_no = ($row_no-1) * $row_per_page;
        }
        // All records count
        $all_count = $this->Shortener_model->getBlocklistURLCount();
        // Get records
        $result = $this->Shortener_model->getBlocklistURL($row_per_page, $row_no);
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
    public function generateNewSecretKey()
    {
        $new_secret_key = $this->User_model->generateSecretKey();
        $data = $this->Shortener_model->generateNewSecretKey($new_secret_key);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function disableMultipleURL()
    {
        $data = $this->Shortener_model->disableMultipleURL();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function googleSafeBrowsingURLScanEveryDay() 
    {
        /* 
         | Scan new registered URLs twice a day AND every 6 hours
        */ 

        $start_date = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 23:59:59');
    	$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);

        $url_array = $this->Shortener_model->UrlToScanRegisteredToday($date_range);
        $url_count = $this->Shortener_model->UrlToScanRegisteredTodayCount($date_range);

        $scanned_data = array(
            'scanned_url'=>$url_count,
            'URLs'=>$url_array
        );
        $message = "Scanned URLs today: ".$url_count; 
        $this->Shortener_model->insertActivityLog($message); 

        $data['scanned_data'] =  $scanned_data;
        $data['url_data'] =  $url_array;
        $this->load->view('account/url_scanner', $data);    
    }
    public function googleSafeBrowsingURLScan(){
        /* 
         | Scan new registered URLs twice a day AND every 6 hours
        */ 
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        if($from == 'monthly' && $to == 'monthly') {
            $start_date = date('Y-m-01 00:00:00');
            $end_date = date('Y-m-t 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
        else{
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }

        $message_status = "";
        $curl_message = "";
        

        $url_array = $this->Shortener_model->UrlToScanRegisteredToday($date_range);
        $url_count = $this->Shortener_model->UrlToScanRegisteredTodayCount($date_range);

        $url_to_scan = "";
        foreach ($url_array as $ud) {      
            $url_to_scan .= '{"url"'.': "'.$ud["url"].'"},' ;
        }
        
        $message1 = "Scanned URLs: ".$url_count; 
        $this->Shortener_model->insertActivityLog($message1); 
        $data['scanned_data'] = array(
            'url_count' => $url_count,
            // 'message' => $message1,
            'url_to_scan' => $url_array, # url_array OR url_to_scan
        );
        $data['url_to_scan'] = $url_to_scan;
        $this->load->view('account/url_scanner', $data);   

        // $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function googleSafeBrowsingURLScanV2(){
        /* 
         | Scan new registered URLs twice a day AND every 6 hours
        */ 
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        if($from == 'monthly' && $to == 'monthly') {
            $start_date = date('Y-m-01 00:00:00');
            $end_date = date('Y-m-t 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
        else{
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
        $message_status = "";
        $curl_message = "";
        $url_array = $this->Shortener_model->UrlToScanRegisteredToday($date_range);
        $url_count = $this->Shortener_model->UrlToScanRegisteredTodayCount($date_range);

        $url_to_scan = "";
        foreach ($url_array as $ud) {      
            $url_to_scan .= '{"url"'.': "'.$ud["url"].'"},' ;
        }
        $safe_browsing_response = $this->safeBrowsingApi($url_array, $url_count);
        $data['scanned_data'] = array(
            'url_count' => $url_count,
            'safe_browsing_response' => $safe_browsing_response,
            'url_to_scan' => $url_array, # url_array OR url_to_scan
        );
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function safeBrowsingApi($url_to_scan, $url_count){
        $api_key = 'AIzaSyDck2wgJU_lerRlt8WHCOo8aQnb01AKpYo';
        $api_url = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $api_key;
        $request_data = [
            'client' => [
                'clientId' => 'shortlyapp382402',
                'clientVersion' => '382402',
            ],
            'threatInfo' => [
                'threatTypes' => ["MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE", "CSD_DOWNLOAD_WHITELIST","POTENTIALLY_HARMFUL_APPLICATION","THREAT_TYPE_UNSPECIFIED"],
                'platformTypes' => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [
                     rtrim($url_to_scan,',')
                ],
            ],
        ];
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_REFERER, "https://shortly.at/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
        $response = curl_exec($ch);
        if (curl_errno($ch)) 
        {
            $curl_message = "cURL error: " . curl_error($ch);
            $this->Shortener_model->insertActivityLog($curl_message);
        } 
        else 
        {
            $curl_message = "";
            $result = json_decode($response, true);
            if (isset($result['matches']) && !empty($result['matches'])) 
            {
                $msg = 'The URL is flagged as a threat.';
                $message1 = "Scanned URLs: ".$url_count; 
                $this->Shortener_model->insertActivityLog($message1); 
                $blocked_url = array();
                foreach($result['matches'] as $match){
                    $array = array(
                        "url"=>$match['threat']['url'],
                    );
                    array_push($blocked_url, $array);
                }
                $this->Shortener_model->blockURLGoogleURLScan($blocked_url);
                $this->Shortener_model->disableURLGoogleURLScan($blocked_url);
                $message_status = "Blocked URLs: ".implode(", ", $blocked_url );
                $this->Shortener_model->insertActivityLog($message_status);
            } 
            else 
            {
                $message1 = "Scanned URLs: ".$url_count; 
                $this->Shortener_model->insertActivityLog($message1); 
                $message_status = "No unwanted URLs";
                $this->Shortener_model->insertActivityLog($message_status); 
            }
        }
        curl_close($ch);
        return $response;
    }
    public function blockURLGoogleURLScan(){
		$url_array = $this->input->post('url_array');
        $data = $this->Shortener_model->blockURLGoogleURLScan($url_array);
        $data = $this->Shortener_model->disableURLGoogleURLScan($url_array);

        $message = "Blocked URLs: ".implode(", ",$url_array);
        $this->Shortener_model->insertActivityLog($message); 


        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function cronTest(){
        /* wget -q -O /dev/null "https://shortly.at/shortener/cronTest" > /dev/null 2>&1 */ 
        $message = "Testing cron auto! Yes";
        $this->Shortener_model->insertActivityLog($message); 
    }
    public function insertActivityLog(){
        $message = $this->input->get('message');
        $this->Shortener_model->insertActivityLog($message); 
    }
}