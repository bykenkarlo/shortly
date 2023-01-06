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
		$data = $this->db->SELECT('long_url')->WHERE("short_url",$url_param)->GET('shortened_url_tbl')->row_array();
		if(!empty($data)){
			$long_url = $data['long_url'];
		}
		return $long_url;
	}
	public function getURLData() {
		$url_param = $this->input->get('url_param');
		$data = $this->db->SELECT('sut.long_url, sut.short_url, COUNT(st.click_id) as total_click, sut.created_at')
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
				if (strpos($referrer, 'facebook.com') !== false) { 
					$referrer = 'https://facebook.com/';
				}
				else if (strpos($referrer, 'messenger.com') !== false) { 
					$referrer = 'https://messenger.com/';
				}
				else if (strpos($referrer, 'twitter.com') !== false) { 
					$referrer = 'https://twitter.com/';
				}
				else if (strpos($referrer, 'github.com') !== false) { 
					$referrer = 'https://github.com/';
				}
				else if (strpos($referrer, 'linkedin.com') !== false) { 
					$referrer = 'https://linkedin.com/';
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
				'country'=>$location['country'],
				'city'=>$location['city'],
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
		$range = $this->input->get('range');
		if($range == '7_days') {
			$start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
			$end_date = date('Y-m-d 23:59:59');
			$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
			$groupBy = 'DATE(created_at)';
		}

			else if($range == '30_days') {
				$start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
				$end_date = date('Y-m-d 23:59:59');
				$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
				$groupBy = 'DATE(created_at)';
			}
			else if($range == '1_year') {
				$start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
				$end_date = date('Y-m-d 23:59:59');
				$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
				$groupBy = 'DATE(created_at)';
			}
	 
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
		$range = $this->input->get('range');
		if($range == '7_days') {
			$start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
			$end_date = date('Y-m-d 23:59:59');
			$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
			$groupBy = 'referrer';
		}
		else if($range == '30_days') {
			$start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
			$end_date = date('Y-m-d 23:59:59');
			$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
			$groupBy = 'referrer';
		}
		else if($range == '1_year') {
			$start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
			$end_date = date('Y-m-d 23:59:59');
			$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
			$groupBy = 'referrer';
		}
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
			else if($q['referrer'] == '' || !$q['referrer']){
				$q['referrer'] = 'Other';
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
		$range = $this->input->get('range');
		if($range == '7_days') {
			$start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
			$end_date = date('Y-m-d 23:59:59');
			$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
			$groupBy = 'country';
		}

			else if($range == '30_days') {
				$start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
				$end_date = date('Y-m-d 23:59:59');
				$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
				$groupBy = 'country';
			}
			else if($range == '1_year') {
				$start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
				$end_date = date('Y-m-d 23:59:59');
				$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
				$groupBy = 'country';
			}
	 
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
		$range = $this->input->get('range');
		if($range == '7_days') {
			$start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
			$end_date = date('Y-m-d 23:59:59');
			$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
			$groupBy = 'browser';
		}

			else if($range == '30_days') {
				$start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
				$end_date = date('Y-m-d 23:59:59');
				$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
				$groupBy = 'browser';
			}
			else if($range == '1_year') {
				$start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
				$end_date = date('Y-m-d 23:59:59');
				$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
				$groupBy = 'browser';
			}
	 
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
		$range = $this->input->get('range');
		if($range == '7_days') {
			$start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
			$end_date = date('Y-m-d 23:59:59');
			$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
			$groupBy = 'platform';
		}

			else if($range == '30_days') {
				$start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
				$end_date = date('Y-m-d 23:59:59');
				$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
				$groupBy = 'platform';
			}
			else if($range == '1_year') {
				$start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
				$end_date = date('Y-m-d 23:59:59');
				$date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
				$groupBy = 'platform';
			}
	 
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

		// USING IPREGISTRY.CO
		// $api_key = '3znwiuvs1majuisp';
		// $url = 'https://api.ipregistry.co/'.$ip_address.'?key=3znwiuvs1majuisp';
		// $ip_data = json_decode(file_get_contents($url));
		// $data['country'] = $ip_data->location->country->name;
		// $data['city'] = $ip_data->location->city;

		$access_token = 'a44d209805c142';
		$client = new IPinfo($access_token);
		$details = $client->getDetails($ip_address);

		$data['country'] = $details->country_name; 
		$data['city'] = $details->city; 
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
}