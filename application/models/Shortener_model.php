<?php
use ipinfo\ipinfo\IPinfo;
use ImageKit\ImageKit;  

defined('BASEPATH') OR exit('No direct script access allowed');

class Shortener_model extends CI_Model {

	public function processUrl(){
		$long_url = $this->input->post('long_url');
		$short_url = "";
		if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $long_url)) {
		// if (filter_var($long_url, FILTER_VALIDATE_URL) === FALSE) {
			$response['status'] = 'error';
			$response['short_url'] = "";
			$response['message'] = "Please enter a correct URL!";
		}
		else if(!empty($long_url)) {
			$short_url = $this->shortURLGenerator();
			$data_arr = array(
				'long_url'=>$long_url,
				'short_url'=>$short_url,
				'status'=>'active',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('shortened_url_tbl', $data_arr);
	
			$response['status'] = 'success';
			$response['message'] = "Here's your short URL ".base_url().$short_url.".";
			$response['attribute'] = array('param'=>$short_url,'url'=>base_url().$short_url);
		}
		
		return $response;

	}
	public function shortURLGenerator($length = 5) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $param = '';
	    for ($i = 0; $i < $length; $i++) {
	        $param .= $characters[rand(0, $charactersLength - 1)];
	    }
		$check = $this->db->WHERE('short_url',$param)->GET('shortened_url_tbl')->num_rows();
		if($check > 0){
			$this->shortURLGenerator();
		}
		else{
			return $param;
		}
   	}
   	public function accessLongURL($url_param) {
		$long_url = "";
		$data = $this->db->SELECT('long_url')->WHERE("short_url",$url_param)->WHERE('status','active')->GET('shortened_url_tbl')->row_array();
		if(!empty($data)){
			$long_url = $data['long_url'];
		}
		return $long_url;
	}
	public function checkURLData($param) {
		return $this->db->WHERE('short_url',$param)->GET('shortened_url_tbl')->num_rows();
	}
	public function getURLDataByURLParam($url_param) {
		return $this->db->WHERE('short_url',$url_param)->GET('shortened_url_tbl')->row_array();
	}
	public function getURLData() {
		$url_param = $this->input->get('url_param');
		$data = $this->db->SELECT('sut.long_url, sut.short_url, sut.status, COUNT(st.click_id) as total_click, sut.created_at')
			->FROM('shortened_url_tbl as sut')
			->JOIN('statistics_tbl as st','st.url_param=sut.short_url','left')
			->WHERE('sut.short_url',$url_param)
			->GET()->row_array();

		if(!empty($data)){
			$logo_img = $this->getImageLogo($url_param);
			$response = array(
				'short_url'=> preg_replace("(^https?://)", "", base_url().$data['short_url'] ),
				'redirect_url'=>$data['long_url'],
				'url_param'=>$data['short_url'],
				'status'=>$data['status'],
				'total_click'=>$data['total_click'],
				'logo_img'=>$logo_img,
				'created_at'=>date('F d, Y h:i A', strtotime($data['created_at']))
			);
			return $response;
		}
		else{
			return false;
		}
	}
	public function recordUserClick($url_param) {
		$browser = $this->agent->browser();
		$platform = $this->agent->platform();

		if($this->session->click_session !== $url_param && !empty($browser) && $platform !== 'Unknown Platform'){
			if(isset($_SERVER['HTTP_REFERER'])) {
				$referrer = $_SERVER['HTTP_REFERER'];
				if (strpos($referrer, 'facebook') !== false || strpos($referrer, 'fb') !== false) { 
					$referrer = 'https://facebook.com/';
				}
				else if (strpos($referrer, 'messenger.com') !== false || strpos($referrer, 'm.me') !== false) { 
					$referrer = 'https://messenger.com/';
				}
				else if (strpos($referrer, 'youtube') !== false) { 
					$referrer = 'https://youtube.com/';
				}
				else if (strpos($referrer, 'twitter') !== false || strpos($referrer, 't.co') !== false) { 
					$referrer = 'https://twitter.com/';
				}
				else if (strpos($referrer, 'github') !== false) { 
					$referrer = 'https://github.com/';
				}
				else if (strpos($referrer, 'linkedin') !== false) { 
					$referrer = 'https://linkedin.com/';
				}
				else if (strpos($referrer, 'google') !== false) { 
					$referrer = 'https://google.com/';
				}
				else if (strpos($referrer, 'mail.google.com') !== false) { 
					$referrer = 'https://gmail.google.com/';
				}
				else if (strpos($referrer, 'protonmail.com') !== false) { 
					$referrer = 'https://protonmail.com/';
				}
			}
			else {
				$referrer = '';
			}

			$click_id = $this->generateClickID();
			$location = $this->getLocationData();
			$data_arr = array(
				'click_id'=>$click_id,
				'url_param'=>$url_param,
				'browser'=>$browser,
				'platform'=>$platform,
				'referrer'=>$referrer,
				'country'=>($location['country'])?$location['country']:'',
				'city'=>($location['city'])?$location['city']:'',
				'created_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->INSERT('statistics_tbl', $data_arr);
			$this->session->set_tempdata('click_session', $url_param, 86400); /* set session visitor views for 24 hours then reset after */
		}
	}
	public function generateClickID ($length = 32) {
        $click_id = sprintf( '%04x-%04x-%04x-%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0C2f ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
        );
        $check = $this->db->WHERE('click_id',$click_id)->GET('statistics_tbl')->num_rows();
        if ($check > 0) {
            $this->generateClickID();
        }
        else{
           return $click_id;
        }
    }
	public function getClickStat() {
		$url_param = $this->input->get('url_param');
		$start_date = date('Y-m-d 00:00:00',strtotime($this->input->get('from')));
		$end_date = date('Y-m-d H:i:s',strtotime($this->input->get('to')));
		$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
		$groupBy = 'DATE(created_at)';
		
		$click_stat_data = $this->db->SELECT('DATE(created_at) as date, COUNT(click_id) as clicks')
			->WHERE($date_range)
			->WHERE('url_param',$url_param)
			->GROUP_BY($groupBy)
			->ORDER_BY('created_at','asc')
			->GET('statistics_tbl')->result_array();
	
		$result = array();
		foreach($click_stat_data as $q){
			$array = array(
				'date'=>date('M d, Y', strtotime($q['date'])),
				'clicks'=>$q['clicks']
			);
			array_push($result, $array);
		}
		$data['click_statistics'] = $result;
		return $data;
	}
	public function getReferrerStat() {
		$url_param = $this->input->get('url_param');
		$start_date = date('Y-m-d 00:00:00',strtotime($this->input->get('from')));
		$end_date = date('Y-m-d H:i:s',strtotime($this->input->get('to')));
		$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
		$groupBy = 'referrer';
		$click_stat_data = $this->db->SELECT('count(referrer) as count, referrer')
			->WHERE($date_range)
			->WHERE('url_param',$url_param)
			->GROUP_BY($groupBy)
			->ORDER_BY('count','desc')
			->ORDER_BY('referrer','asc')
			->GET('statistics_tbl')->result_array();
		$result = array();
		foreach($click_stat_data as $q){
			if(!empty($q['referrer'])) {
				$parse = parse_url($q['referrer']);
				$q['referrer'] = $parse['host'];
			}
			

			if($q['referrer'] == '' || !$q['referrer']){
				$q['referrer'] = 'Direct';
			}
			else if(strpos($q['referrer'], 'google') !== false){
				$q['referrer'] = 'Google';
			}
			else if(strpos($q['referrer'], 'youtube') !== false){
				$q['referrer'] = 'Youtube';
			}
			else if(strpos($q['referrer'], 'facebook') !== false || strpos($q['referrer'], 'fb') !== false ){
				$q['referrer'] = 'Facebook';
			}
			else if(strpos($q['referrer'], 'mail.google') !== false){
				$q['referrer'] = 'Gmail';
			}
			$referrer = ucfirst(preg_replace("(^https?://)", "", $q['referrer'] ));
			$array = array(
				'count'=>$q['count'],
				'referrer'=>$referrer
			);
			array_push($result, $array);
		}
		$data['referrer_statistics'] = $result;
		return $data;
	}
	public function getLocationStat() {
		$url_param = $this->input->get('url_param');
		$start_date = date('Y-m-d 00:00:00',strtotime($this->input->get('from')));
		$end_date = date('Y-m-d H:i:s',strtotime($this->input->get('to')));
		$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
		$groupBy = 'country';
	 
		$click_stat_data = $this->db->SELECT('count(country) as count, country')
			->WHERE($date_range)
			->WHERE('url_param',$url_param)
			->GROUP_BY($groupBy)
			->ORDER_BY('count','desc')
			->ORDER_BY('country','asc')
			->GET('statistics_tbl')->result_array();
			
		$total_count = $this->db->SELECT('count(country) as total_count')
			->WHERE($date_range)
			->WHERE('url_param',$url_param)
			->GET('statistics_tbl')->row_array();
		$result = array();
		foreach($click_stat_data as $q){
			if($q['country'] == '' || !$q['country']){
				$q['country'] = 'Other';
			}
			$array = array(
				'count'=>$q['count'],
				'percentage' => round(($q['count'] / $total_count['total_count']) * 100, 2),
				'country'=>$q['country']
			);
			array_push($result, $array);
		}
		$data['total_count'] = $total_count['total_count'];
		$data['country_statistics'] = $result;
		return $data;
	}
	public function getBrowserStat() {
		$url_param = $this->input->get('url_param');
		$start_date = date('Y-m-d 00:00:00',strtotime($this->input->get('from')));
		$end_date = date('Y-m-d H:i:s',strtotime($this->input->get('to')));
		$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
		$groupBy = 'browser';
	 
		$click_stat_data = $this->db->SELECT('count(browser) as count, browser')
			->WHERE($date_range)
			->WHERE('url_param',$url_param)
			->GROUP_BY($groupBy)
			->ORDER_BY('created_at','asc')
			->GET('statistics_tbl')->result_array();
	
		$result = array();
		foreach($click_stat_data as $q){
				
			$array = array(
				'count'=>$q['count'],
				'browser'=>$q['browser']
			);
			array_push($result, $array);
		}
		$data['browser_statistics'] = $result;
		return $data;
	}
	public function getPlatformStat() {
		$url_param = $this->input->get('url_param');
		$start_date = date('Y-m-d 00:00:00',strtotime($this->input->get('from')));
		$end_date = date('Y-m-d H:i:s',strtotime($this->input->get('to')));
		$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
		$groupBy = 'platform';
		$click_stat_data = $this->db->SELECT('count(platform) as count, platform')
			->WHERE($date_range)
			->WHERE('url_param',$url_param)
			->GROUP_BY($groupBy)
			->ORDER_BY('created_at','asc')
			->GET('statistics_tbl')->result_array();
	
		$result = array();
		foreach($click_stat_data as $q){
			
			$array = array(
				'count'=>$q['count'],
				'platform'=>$q['platform']
			);
			array_push($result, $array);
		}
		$data['platform_statistics'] = $result;
		return $data;
	}
	public function getLocationData(){
		$ip_address = $this->input->ip_address();
		// check if server is localhost
		if (strpos(base_url(), 'localhost') !== false) { 
			$ip_address = '143.44.165.74';
		}
		// USING IPLIST.CC
		// $ip_data = json_decode(file_get_contents('https://iplist.cc/api/'.$ip_address));
		// $data['country'] = $ip_data->countryname; 
		// $data['city'] = ''; 

		// USING IPREGISTRY.CO
		$api_key = '3znwiuvs1majuisp';
		$url = 'https://api.ipregistry.co/'.$ip_address.'?key=3znwiuvs1majuisp';
		$ip_data = json_decode(file_get_contents($url));
		$data['country'] = $ip_data->location->country->name;
		$data['city'] = $ip_data->location->city;

		// IPINFO
		// $access_token = 'a44d209805c142';
		// $client = new IPinfo($access_token);
		// $details = $client->getDetails($ip_address);

		// if limit is used
		
		return $data;
	}
	public function uploadCustomLogo($data){
		$check_data = $this->db->WHERE('url_param',$data['url_param'])->GET('uploaded_img_tbl')->num_rows();
		if($check_data > 0) {
			$this->db->WHERE('url_param',$data['url_param'])->UPDATE('uploaded_img_tbl',$data);
		}
		else{
			$this->db->INSERT('uploaded_img_tbl',$data);
		}	
	}
	public function getImageLogo($url_param){
		$query = $this->db->WHERE('url_param',$url_param)
			->GET('uploaded_img_tbl')->row_array();
		if(!empty($query)) {
			if (strpos(base_url(), 'localhost') !== false || strpos(base_url(), 'test') !== false ) { 
                return $query['image'];
            }
			else{
				return $query['image'];
			}
			
		}
		else{
			return '';
		}
	}
	public function getEmailAddress(){
		$data = $this->db->SELECT('recovery_email')->GET('site_settings_tbl')->row_array();
		return array('email_address'=>$data['recovery_email']);
	}
	public function customizeUrl(){
		$url_param = $this->input->post('url_param');
		$edit_url_param = $this->input->post('edit_url_param');
		$check_param = $this->checkURLData($edit_url_param);
		if($check_param > 0){
			$response['status'] = 'error';
			$response['message'] = "URL is already taken!";
			$response['attribute'] = "";
		}
		else if(strlen($edit_url_param) < 4) {
			$response['status'] = 'error';
			$response['message'] = "Only a minimum of 4 characters is allowed!";
			$response['attribute'] = "";
		}
		else if(strlen($edit_url_param) > 18) {
			$response['status'] = 'error';
			$response['message'] = "Only a maximum of 18 characters is allowed!";
			$response['attribute'] = "";
		} 
		else if(!empty($url_param) && !empty($edit_url_param)){
			if(!preg_match('/[^a-z\-0-9]/i', $edit_url_param)) {
				$data_arr = array(
					'short_url'=>$edit_url_param,
					'updated_at'=>date('Y-m-d H:i:s'),
				);
				$data_arr2 = array(
					'url_param'=>$edit_url_param,
					'updated_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->WHERE('short_url',$url_param)->UPDATE('shortened_url_tbl', $data_arr);
				$this->db->WHERE('url_param',$url_param)->UPDATE('statistics_tbl', $data_arr2);
				$this->db->WHERE('url_param',$url_param)->UPDATE('account_url_tbl', $data_arr2);
				$this->db->WHERE('url_param',$url_param)->UPDATE('uploaded_img_tbl', $data_arr2);

				$response['status'] = 'success';
				$response['message'] = "Succesfuly customize your URL!";
				$response['attribute'] = array('new_url'=>base_url().$edit_url_param.'-');
			}
			else{
				$response['status'] = 'error';
				$response['message'] = "Only alphanumeric characters and dash is allowed!";
				$response['attribute'] = "";
			}
			
		}
		else{
			$response['status'] = 'error';
			$response['message'] = "";
			$response['attribute'] = "";
		}
		return $response;
	}
	public function changeStatus(){
		$status = $this->input->post('status');
		$data_arr = array('status'=>$status);

		$this->db->WHERE('short_url',$this->input->post('url_param'))->UPDATE('shortened_url_tbl',$data_arr);

		if ($this->db->affected_rows() > 0) {
			$response['status'] = 'success';
			$response['message'] = "Status successfully updated to ".$status;
			$response['attribute'] = "";
		}else{
			$response['status'] = 'error';
			$response['message'] = "Row cannot be updated. Please try again!";
			$response['attribute'] = "";
		}
		return $response;
	}
	public function getAccountURLData(){
		$url_param = $this->input->get('url_param');
		if($url_param === null){
			$query = $this->db->SELECT('sut.long_url, sut.short_url, aut.title, sut.status, COUNT(st.click_id) as total_click, uit.image, sut.created_at')
			->FROM('shortened_url_tbl as sut')
			->JOIN('statistics_tbl as st','st.url_param=sut.short_url','left')
			->JOIN('uploaded_img_tbl as uit','uit.url_param=sut.short_url','left')
			->JOIN('account_url_tbl as aut','aut.url_param=sut.short_url','left')
			->ORDER_BY('sut.created_at','desc')
			->LIMIT(0,1)
			->GET()->row_array();
		}
		else{
			$query = $this->db->SELECT('sut.long_url, sut.short_url, aut.title, sut.status, COUNT(st.click_id) as total_click, uit.image, sut.created_at')
			->FROM('shortened_url_tbl as sut')
			->JOIN('statistics_tbl as st','st.url_param=sut.short_url','left')
			->JOIN('uploaded_img_tbl as uit','uit.url_param=sut.short_url','left')
			->JOIN('account_url_tbl as aut','aut.url_param=sut.short_url','left')
			->WHERE('sut.short_url',$url_param)
			->GET()->row_array();
		}

		$data = array(
			'title'=>($query['title'])?$query['title']:str_replace(array('http://','https://'),'',base_url().$query['short_url']),
			'short_url'=>$query['short_url'],
			'redirect_url'=>$query['long_url'],
			'total_click'=>$query['total_click'],
			'logo_image'=>$query['image'],
			'select_date'=>date('m/d/Y', strtotime($query['created_at'])).'-'.date('m/t/Y'),
			'created_at'=>date('M d, Y h:i A', strtotime($query['created_at'])),
		);
		return $data;
	}
	public function getAccountURLDataV2(){
		$url_param = $this->input->get('url_param');
		$query = $this->db->SELECT('sut.long_url, sut.short_url, aut.title, sut.status,sut.created_at')
			->FROM('shortened_url_tbl as sut')
			->JOIN('account_url_tbl as aut','aut.url_param=sut.short_url','left')
			->WHERE('sut.short_url',$url_param)
			->GET()->row_array();

		$data = array(
			'title'=>($query['title'])?$query['title']:str_replace(array('http://','https://'),'',base_url().$query['short_url']),
			'short_url'=>$query['short_url'],
			'redirect_url'=>$query['long_url'],
			'created_at'=>date('M d, Y h:i A', strtotime($query['created_at'])),
		);
		return $data;
	}
	public function newShortURL(){
		if(isset($this->session->secret_key)){
			$long_url = $this->input->post('redirect_url');
			$title = $this->input->post('title');
			$custom_link = $this->input->post('custom_link');
			$check_url_param = $this->db->WHERE('short_url', $custom_link)->GET('shortened_url_tbl')->num_rows();
			if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $long_url)) {
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Please enter a correct URL!";
			}
			else if($check_url_param > 0){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL already exist!";
			}
			else if(strlen($custom_link) < 4 ){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL should be at least 4 characters";
			}
			else if(strlen($custom_link) > 30){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL should not be more than 30 characters";
			}
			else if(!empty($long_url)) {
				$short_url = ($custom_link!=='')?$custom_link:$this->shortURLGenerator();
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
				$this->db->INSERT('shortened_url_tbl', $data_arr);
				$this->db->INSERT('account_url_tbl', $data_arr2);

				$response['status'] = 'success';
				$response['message'] = "Here's your short URL ".base_url().$short_url.".";
				$response['attribute'] = array('param'=>$short_url,'url'=>base_url().$short_url);
			}
			return $response;
		}
		else{
			$response['status'] = 'error';
			$response['short_url'] = "";
			$response['message'] = "Something went wrong! Refresh the page and try again!";
		}
	}
	public function saveCustomURL(){
		if(isset($this->session->secret_key)){
			$long_url = $this->input->post('redirect_url');
			$title = $this->input->post('title');
			$custom_link = $this->input->post('custom_link');
			$prev_param = $this->input->post('url_param_edit');

			$check_url_param = $this->db->WHERE('short_url', $custom_link)->GET('shortened_url_tbl')->num_rows();
			
			if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $long_url)) {
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Please enter a correct URL!";
			}
			else if($check_url_param > 0 &&  $prev_param !== $custom_link){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL already exist!";
			}
			else if(strlen($custom_link) < 4){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL should be at least 4 characters!";
			}
			else if(strlen($custom_link) > 30){
				$response['status'] = 'error';
				$response['short_url'] = "";
				$response['message'] = "Custom URL should not be more than 30 characters!";
			}
			else if(!empty($long_url) || $prev_param == $custom_link) {
				$short_url = ($custom_link !== '') ? $custom_link : $this->shortURLGenerator();
				$data_arr = array(
					'long_url'=>$long_url,
					'short_url'=>str_replace(' ','-',$short_url),
					'updated_at'=>date('Y-m-d H:i:s')
				);
				$data_arr2 = array(
					'title'=>($title!=='')?$title:'',
					'url_param'=>str_replace(' ','-',$short_url),
					'updated_at'=>date('Y-m-d H:i:s')
				);
				$data_arr3 = array(
					'url_param'=>str_replace(' ','-',$short_url),
					'updated_at'=>date('Y-m-d H:i:s')
				);
				$this->db->WHERE('short_url',$prev_param)->UPDATE('shortened_url_tbl', $data_arr);
				$this->db->WHERE('url_param',$prev_param)->UPDATE('account_url_tbl', $data_arr2);
				$this->db->WHERE('url_param',$prev_param)->UPDATE('uploaded_img_tbl', $data_arr3);
				$this->db->WHERE('url_param',$prev_param)->UPDATE('statistics_tbl', $data_arr3);

				$response['status'] = 'success';
				$response['message'] = "Here's your short URL ".base_url().$short_url.".";
				$response['attribute'] = array('param'=>$short_url,'url'=>base_url().$short_url);
			}
			return $response;
		}
		else{
			$response['status'] = 'error';
			$response['short_url'] = "";
			$response['message'] = "Something went wrong! Refresh the page and try again!";
		}
	}
	
}