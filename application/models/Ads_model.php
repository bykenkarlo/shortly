<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ads_model extends CI_Model {
    public function getAdDataByAdID($ad_id){
        return $this->db->SELECT('redirect_url')->WHERE('ad_id', $ad_id)->GET('ads_tbl')->row_array();
    }
    public function showAdData($type){
        return $this->db->SELECT('name, ad_id, redirect_url, description, logo, button_text, button_color, image')
            ->WHERE('type', $type)
            ->WHERE('status', 'active')
            ->ORDER_BY('id', 'RANDOM')
            ->GET('ads_tbl')->row_array();
    }
    public function save(){
        $data_arr = array(
            'name'=>$this->input->post('name'),
            'ad_id'=>$this->generateAdID(),
            'redirect_url'=>$this->input->post('url'),
            'type'=>$this->input->post('type'),
            'description'=>$this->input->post('description'),
            'image'=>($this->input->post('banner'))? $this->input->post('banner'):'',
            'logo'=>($this->input->post('logo'))? $this->input->post('logo'):'',
            'button_color'=>($this->input->post('button_color'))? $this->input->post('button_color'):'',
            'button_text'=>($this->input->post('button_text'))? $this->input->post('button_text'):'',
            'status'=>'active',
            'created_at'=>date('Y-m-d H:i:s')
        );
        $this->db->INSERT('ads_tbl',$data_arr);
        $response['status'] = 'success';
        $response['message'] = 'New Ad added!';
        return $response;
    }
    public function generateAdID($length = 15){
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $temp_id = '';
        for ($i = 0; $i < $length; $i++) {
            $temp_id .= $characters[rand(0, $charactersLength - 1)];
        }
        $check = $this->db->WHERE('ad_id',$temp_id)->GET('ads_tbl')->num_rows();
        if($check > 0){
            $this->generateAdID();
        }
        else{
            return $temp_id;
        }
    }
    public function getAdsList($row_per_page, $row_no){
        if (isset($this->session->admin)) {
            $search = $this->input->get('search');
            if(empty($search) || $search == ''){
                $query = $this->db->SELECT('at.*')
                 ->FROM('ads_tbl as at')
                 ->LIMIT($row_per_page, $row_no)
                 ->ORDER_BY('at.created_at','desc')
                 ->GET()->result_array();
            }
            else{
                $query = $this->db->SELECT('at.*')
                 ->FROM('ads_tbl as at')
                 ->WHERE("(at.name LIKE '%".$search."%' OR at.redirect_url LIKE '%".$search."%' OR at.type LIKE '%".$search."%')", NULL, FALSE)
                 ->LIMIT($row_per_page, $row_no)
                 ->ORDER_BY('at.created_at','desc')
                 ->GET()->result_array();
            }
            $result = array();
            foreach($query as $q){
            $clicks = $this->db->WHERE('ad_id', $q['ad_id'])->GET('ad_stat_tbl')->num_rows();

                $array = array(
                    'id'=>$q['id'],
                    'ad_id'=>$q['ad_id'],
                    'name'=>$q['name'],
                    'redirect_url'=>$q['redirect_url'],
                    'clicks'=>$clicks,
                    'type'=>ucwords($q['type']),
                    'status'=>$q['status'],
                    'created_at'=>date('d/m/Y h:i A', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
            return $result;
        }
    }
    public function getAdsListCount(){
        if (isset($this->session->admin)) {
            $search = $this->input->get('search');
            if(empty($search) || $search == ''){
                $query = $this->db->SELECT('at.*')
                 ->FROM('ads_tbl as at')
                 ->GET()->num_rows();
            }
            else{
                $query = $this->db->SELECT('at.*')
                 ->FROM('ads_tbl as at')
                 ->WHERE("(at.name LIKE '%".$search."%' OR at.redirect_url LIKE '%".$search."%')", NULL, FALSE)
                 ->GET()->num_rows();
            }
           
            return $query;
        }
    }
    public function changeStatus(){
        $data_arr = array(
            'status'=>$this->input->post('status'),
            'updated_at'=>date('Y-m-d H:i:s')
        );
        $this->db->WHERE('ad_id', $this->input->post('ad_id'))->UPDATE('ads_tbl', $data_arr);
        $response['status'] = 'success';
        $response['message'] = 'Ad successfully updated!';
        return $response;
    }
    public function delete(){
        $this->db->WHERE('ad_id', $this->input->post('ad_id'))->DELETE('ads_tbl');
        $response['status'] = 'success';
        $response['message'] = 'Ad successfully deleted!';
        return $response;
    }
    public function recordClick($ad_id, $location, $click_id) {
		$browser = $this->agent->browser();
		$platform = $this->agent->platform();
		if($this->session->ad_click_session !== $ad_id && !empty($browser) && $platform !== 'Unknown Platform'){
			$data_arr = array(
				'ad_id'=>$ad_id,
				'click_id'=>$click_id,
				'browser'=>$browser,
				'platform'=>$platform,
				'country'=>($location['country'])?$location['country']:'',
				'city'=>($location['city'])?$location['city']:'',
				'created_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->INSERT('ad_stat_tbl', $data_arr);
			$this->session->set_tempdata('ad_click_session', $ad_id, 86400); /* set session visitor views for 24 hours then reset after */
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
        $check = $this->db->WHERE('click_id', $click_id)->GET('ad_stat_tbl')->num_rows();
        if ($check > 0) {
            $this->generateClickID();
        }
        else{
           if(!empty($click_id)){
				return $click_id;
		   }
		   else{
        		$this->generateClickID();
		   }
        }
    }
}