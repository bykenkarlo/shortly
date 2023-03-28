<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function checkUserData($username) {
		return $this->db
			->WHERE('username', $username)
			->OR_WHERE('secret_key', $username)
			->GET('users_tbl')->row_array();
	}
	public function insertNewRememberLogin($rememberLogin){
        if ($this->agent->is_mobile()) {
            $device = 'mobile_rem_token';
        }
        else{
            $device = 'web_rem_token';
        }
		$data = array($device=>$rememberLogin);
		$this->db->WHERE('user_id', $this->session->user_id)
			->UPDATE('users_tbl', $data);
	}
	
}