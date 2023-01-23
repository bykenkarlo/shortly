<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {
    public function getURLList($row_per_page, $row_no){
        if (isset($this->session->admin)) {
            // $from = $this->input->get('from');
            // $to = $this->input->get('to');

            // $start_date = date('Y-m-d 00:00:00', strtotime($from));
            // $end_date = date('Y-m-d 23:59:59', strtotime($to));
            // $date_range = array('lt.due_date >'=>$start_date, 'lt.due_date <'=> $end_date);

            // $search = $this->input->get('search');
            // $opt_status = $this->input->get('status');

            $query = $this->db->SELECT('sut.*')
                 ->FROM('shortened_url_tbl as sut')
                 // ->WHERE("(lt.loan_no LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lt.account_no LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                 ->LIMIT($row_per_page, $row_no)
                 // ->WHERE($date_range)
                 ->ORDER_BY('created_at','desc')
                 ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $click_count = $this->db->WHERE('url_param',$q['short_url'])->GET('statistics_tbl')->num_rows();
                $array = array(
                    'url_param'=>$q['short_url'],
                    'short_url'=>base_url().$q['short_url'],
                    'short_url_stat'=>base_url('stat/').$q['short_url'],
                    'long_url'=>$q['long_url'],
                    'click_count'=>$click_count,
                    'status'=>$q['status'],
                    'created_at'=>date('d/m/Y', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
            return $result;
        }
    }
    public function getURLListCount(){
        if (isset($this->session->admin)) {
            // $from = $this->input->get('from');
            // $to = $this->input->get('to');

            // $start_date = date('Y-m-d 00:00:00', strtotime($from));
            // $end_date = date('Y-m-d 23:59:59', strtotime($to));
            // $date_range = array('lt.due_date >'=>$start_date, 'lt.due_date <'=> $end_date);

            // $search = $this->input->get('search');
            // $opt_status = $this->input->get('status');

            $query = $this->db
                // ->WHERE("(lt.loan_no LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lt.account_no LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                // ->WHERE($date_range)
                ->ORDER_BY('created_at','desc')
                ->GET('shortened_url_tbl')->num_rows();
            return $query;
        }
    }
}