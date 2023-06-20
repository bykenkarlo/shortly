<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics_model extends CI_Model {

	
    public function getWebsiteStatsChart () {
        $range = $this->input->get('range');
        if($range == 'today') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
        else if($range == '7_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }

        else if($range == '15_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-15 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }

        else if($range == '1_month') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
        else if($range == '1_year') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
 
        $site_visit = $this->getWebsiteVisitStat($date_range);
        $link_created_stat = $this->getLinkCreatedStat($date_range);
        $link_click_stat = $this->getLinkClickStat($date_range);
        $location_stat = $this->getLocationStat($date_range);
        $browser_stat = $this->getBrowserStat($date_range);
        $platform_stat = $this->getPlatformStat($date_range);
        $referer_stat = $this->getRefererStat($date_range);
        $most_viewed_url = $this->getMostViewedUrlStat();

        $data['site_visit'] = $site_visit;
        $data['link_created_stat'] = $link_created_stat;
        $data['link_click_stat'] = $link_click_stat;
        $data['location_stat'] = $location_stat;
        $data['browser_stat'] = $browser_stat;
        $data['platform_stat'] = $platform_stat;
        $data['referrer_stat'] = $referer_stat;
        $data['most_viewed_url'] = $most_viewed_url;

        return $data;
    }
    public function generateDateTime($range){
        $result = array();
        $timestamp = time();
        for ($i = 0 ; $i < $range ; $i++) {
            $array = array('date'=>date('d/m', $timestamp));
            $timestamp -= 24 * 3600;
        }
        array_push($result, $array);
        return $result;
    }
    public function getWebsiteVisitStat($date_range){
        $groupBy = 'DATE(created_at)';
        $query = $this->db->SELECT('DATE(created_at) as date, COUNT(views_id) as views')
            ->WHERE($date_range)
            ->GROUP_BY($groupBy)
            ->ORDER_BY('created_at','asc')
            ->GET('website_visits_tbl')->result_array();

        $result = array();
        foreach($query as $q){
            $array = array(
                'date'=>date('d/m', strtotime($q['date'])),
                'views'=>$q['views']
            );
            array_push($result, $array);
        }
        return $result;
    }
    public function getLinkCreatedStat($date_range){
        $groupBy = 'DATE(created_at)';
        $query = $this->db->SELECT('DATE(created_at) as date, COUNT(short_url) as count')
            ->WHERE($date_range)
            ->GROUP_BY($groupBy)
            ->ORDER_BY('created_at','asc')
            ->GET('shortened_url_tbl')->result_array();

        $result = array();
        foreach($query as $q){
            $array = array(
                'date'=>date('d/m', strtotime($q['date'])),
                'count'=>$q['count']
            );
            array_push($result, $array);
        }
        return $result;
    }
    public function getLinkClickStat($date_range){
        $groupBy = 'DATE(created_at)';
        $query = $this->db->SELECT('DATE(created_at) as date, COUNT(click_id) as count')
            ->WHERE($date_range)
            ->GROUP_BY($groupBy)
            ->ORDER_BY('created_at','asc')
            ->GET('statistics_tbl')->result_array();

        $result = array();
        foreach($query as $q){
            $array = array(
                'date'=>date('d/m', strtotime($q['date'])),
                'count'=>$q['count']
            );
            array_push($result, $array);
        }
        return $result;
    }
    public function getWebsiteStats(){
        $data['visits_today'] = $this->visitsToday();
        $data['link_created'] = $this->getLinksCreated();
        $data['link_click'] = $this->getLinkClicks();
        return $data;
    }
    public function visitsToday () {
        $start_date = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 23:59:59');
        $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);

        return $this->db->WHERE($date_range)
            ->GET('website_visits_tbl')->num_rows();
    }
    public function getLinksCreated () {
        return $this->db->GET('shortened_url_tbl')->num_rows();
    }
    public function getLinkClicks () {
        return $this->db->GET('statistics_tbl')->num_rows();
    }
    public function getLocationStat($date_range){
		$groupBy = 'country';
		$click_stat_data = $this->db->SELECT('count(country) as count, country')
			->WHERE($date_range)
			->GROUP_BY($groupBy)
            ->LIMIT(15)
			->ORDER_BY('count','desc')
			->ORDER_BY('country','asc')
			->GET('statistics_tbl')->result_array();

		$total_count = $this->db->SELECT('count(country) as total_count')
			->WHERE($date_range)
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
    public function getBrowserStat($date_range){
		$groupBy = 'browser';
		$click_stat_data = $this->db->SELECT('count(browser) as count, browser')
			->WHERE($date_range)
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
    public function getPlatformStat($date_range){
		$groupBy = 'platform';
		$click_stat_data = $this->db->SELECT('count(platform) as count, platform')
			->WHERE($date_range)
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
    public function getRefererStat($date_range){
		$groupBy = 'referrer';
		$click_stat_data = $this->db->SELECT('count(referrer) as count, referrer')
			->WHERE($date_range)
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
    public function getMostViewedUrlStat(){
        $range = $this->input->get('range');
        if($range == 'today') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('st.created_at >'=>$start_date, 'st.created_at <'=> $end_date);
        }
        else if($range == '7_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('st.created_at >'=>$start_date, 'st.created_at <'=> $end_date);
        }

        else if($range == '15_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-15 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('st.created_at >'=>$start_date, 'st.created_at <'=> $end_date);
        }

        else if($range == '1_month') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('st.created_at >'=>$start_date, 'st.created_at <'=> $end_date);
        }
        else if($range == '1_year') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('st.created_at >'=>$start_date, 'st.created_at <'=> $end_date);
        }

        // $groupBy = 'country';
		// $click_stat_data = $this->db->SELECT('count(country) as count, country')


        $groupBy = 'url_param';
        $query = $this->db->SELECT('COUNT(url_param) as views, url_param')
            ->FROM('shortened_url_tbl as sut')
            ->JOIN('statistics_tbl as st','st.url_param=sut.short_url','left')
			->WHERE($date_range)
			->GROUP_BY($groupBy)
			->LIMIT(15)
			->ORDER_BY('views','desc')
			->GET()->result_array();
            
        $total_count = $this->db->SELECT('COUNT(click_id) as total_count')
            ->FROM('shortened_url_tbl as sut') 
            ->JOIN('statistics_tbl as st','st.url_param=sut.short_url','left')
            ->WHERE($date_range)
            ->LIMIT(15)
            ->GET()->row_array();

        $result = array();
        foreach($query as $q){
            $array = array(
                'views'=>$q['views'],
                'percentage'=>round(($q['views'] / $total_count['total_count']) * 100, 2),
                'url_param'=>$q['url_param'],
            );
            array_push($result, $array);
        }
        return $result;
    }
}