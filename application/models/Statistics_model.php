<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics_model extends CI_Model {

	
    public function getWebsiteStatsChart () {
        $range = $this->input->get('range');
        if($range == '7_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
            $date_list = $this->generateDateTime(7);
        }

        else if($range == '15_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-15 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
            $date_list = $this->generateDateTime(15);
        }

        else if($range == '1_month') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
            $date_list = $this->generateDateTime(30);
        }
        else if($range == '1_year') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
            $date_list = $this->generateDateTime(365);
        }
 
        $site_visit = $this->getWebsiteVisitStat($date_range);
        $link_created_stat = $this->getLinkCreatedStat($date_range);
        $link_click_stat = $this->getLinkClickStat($date_range);
        $data['site_visit'] = $site_visit;
        $data['link_created_stat'] = $link_created_stat;
        $data['link_click_stat'] = $link_click_stat;
        return $data;
    }
    public function generateDateTime($range){
        $result = array();
        $timestamp = time();
        for ($i = 0 ; $i < $range ; $i++) {
            $array = array('date'=>date('d/m/y', $timestamp));
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
                'date'=>date('d/m/y', strtotime($q['date'])),
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
                'date'=>date('d/m/y', strtotime($q['date'])),
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
                'date'=>date('d/m/y', strtotime($q['date'])),
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
}