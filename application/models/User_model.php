<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private function hash_password($password){
       return password_hash($password, PASSWORD_BCRYPT);
    }
    public function getCsrfData() {
        $data = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        return $data;
    }
    public function insertActivityLog ($message) {
        if (isset($this->session->user_id)) {
            $activity_log = array(
                'user_id'=>$this->session->user_id, 
                'message_log'=>$message, 
                'ip_address'=>$this->input->ip_address(), 
                'platform'=>$this->agent->platform(), 
                'browser'=>$this->agent->browser(), 
                'created_at'=>date('Y-m-d H:i:s')
            ); 

            $this->db->INSERT('activity_logs_tbl', $activity_log);
        }
    }
    public function getUserData () {
        if (isset($this->session->user_id)) {
            return $this->db->WHERE('user_id', $this->session->user_id)->GET('users_tbl')->row_array();
        }
    }
    public function newWebsiteVisits() {
		if (!isset($this->session->website_views)) {
		    $view_id = $this->generateWebsiteVisitorID();
			$this->session->set_tempdata('website_views', $view_id, 86400); /* set session visitor views for 24 hours then reset after */
			$data = array(
				'views_id'=>$view_id,
				'ip_address'=>$this->input->ip_address(),
				'platform'=>$this->agent->platform(), 
				'browser'=>$this->agent->browser(),
				'created_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->INSERT('website_visits_tbl',$data);
		}
		return true;
	}
    public function generateWebsiteVisitorID($length = 15) {
		$characters = '0123456789abcdef';
	   $charactersLength = strlen($characters);
	   $views_id = '';
	   for ($i = 0; $i < $length; $i++) {
	      $views_id .= $characters[rand(0, $charactersLength - 1)];
	   }
    	return $views_id;
   }










    public function insertActivityLogResetPass ($message) {
        if (isset($this->session->recovery_user_id)) {
            $activity_log = array(
                'user_id'=>$this->session->recovery_user_id, 
                'message_log'=>$message, 
                'ip_address'=>$this->input->ip_address(), 
                'platform'=>$this->agent->platform(), 
                'browser'=>$this->agent->browser(), 
                'created_at'=>date('Y-m-d H:i:s')
            ); 

            $this->db->INSERT('activity_logs_tbl', $activity_log);
        }
    }
    
    public function checkCookie($cookie){
        if ($this->agent->is_mobile()) {
            return $this->db->WHERE('mobile_rem_token', $cookie)
            ->GET('users_tbl')->row_array();
        }
        else{
            return $this->db->WHERE('web_rem_token', $cookie)
            ->GET('users_tbl')->row_array();
        }
    }
    public function getUsers($row_per_page, $row_no){
        if (isset($this->session->user_id)) {
            $search = $this->input->get('search');
            $admins = '(user_type = "admin" OR user_type = "sys_admin")';
            if (isset($this->session->admin)) {
                $query = $this->db->SELECT('user_id, user_type, fname, lname, username, email_address, mobile_number, status, created_at')
                    ->WHERE("(username LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                    ->LIMIT($row_per_page, $row_no)
                    ->WHERE_NOT_IN('user_type','sys_admin')
                    ->ORDER_BY('created_at','desc')
                    ->GET('users_tbl')->result_array();
            }
            else if (isset($this->session->sys_admin)) {
                $query = $this->db->SELECT('user_id, user_type, fname, lname, username, email_address, mobile_number, status, created_at')
                    ->WHERE("(username LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                    ->LIMIT($row_per_page, $row_no)
                    ->ORDER_BY('created_at','desc')
                    ->GET('users_tbl')->result_array();
            }
            else if (isset($this->session->staff)) {
                $query = $this->db->SELECT('user_id, user_type, fname, lname, username, email_address, mobile_number, status, created_at')
                    ->WHERE("(username LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                    ->WHERE_NOT_IN('user_type','sys_admin')
                    ->LIMIT($row_per_page, $row_no)
                    ->ORDER_BY('created_at','desc')
                    ->GET('users_tbl')->result_array();
            }
            $result = array();

            foreach($query as $q){
                $array = array(
                    'user_id'=>$q['user_id'],
                    'user_type'=>$q['user_type'],
                    'username'=>$q['username'],
                    'name'=>ucwords($q['fname'].' '.$q['lname']),
                    'email_address'=>$q['email_address'],
                    'mobile_number'=>$q['mobile_number'],
                    'status'=>$q['status'],
                    'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
            return $result;
        }
    }
    public function getUsersCount(){
        if (isset($this->session->user_id)) {
            $search = $this->input->get('search');
            $admins = '(user_type = "admin" OR user_type = "sys_admin")';
            if (isset($this->session->admin)) {
                $query = $this->db->WHERE("(username LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                    ->WHERE_NOT_IN('user_type','sys_admin')
                    ->ORDER_BY('created_at','desc')
                    ->GET('users_tbl')->num_rows();
            }
            else if (isset($this->session->sys_admin)) {
                $query = $this->db->WHERE("(username LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                    ->ORDER_BY('created_at','desc')
                    ->GET('users_tbl')->num_rows();
            }
            else if (isset($this->session->staff)) {
                $query = $this->db->WHERE("(username LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email_address LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
                    ->WHERE_NOT_IN($admins)
                    ->ORDER_BY('created_at','desc')
                    ->GET('users_tbl')->num_rows();
            }
           
            return $query;
        }
    }
    
    public function updateUserStatus() {
        if (isset($this->session->admin) || isset($this->session->staff) || isset($this->session->sys_admin)) {
            $user_data = $this->db->SELECT('user_id')->WHERE('user_id', $this->input->post('id'))->GET('users_tbl')->row_array();
            $status = $this->input->post('status');
            $dataArr = array('status'=>$status,'updated_at'=>date('Y-m-d H:i:s'));
            if (isset($this->session->staff)) {
                $response['status'] = 'error';
                $response['message'] = 'Action not allowed!';
            }
            else if ($status == 'disabled' && $this->session->user_id == $user_data['user_id']) {
                $response['status'] = 'error';
                $response['message'] = 'Action not allowed!';
            }
            else{
                $this->db->WHERE('user_id', $this->input->post('id'))->UPDATE('users_tbl', $dataArr);
                $response['status'] = 'success';
                $response['message'] = 'User status change to '.$status.'.';
            }
            return $response;
      }
   }

   public function addUser(){
    if (isset($this->session->user_id)) {
        $password = '@kwartz'.date('Y');
        $dataArr = array(
            'fname'=>$this->input->post('fname'),
            'lname'=>$this->input->post('lname'),
            'password'=>$this->hash_password($password),
            'username'=>$this->input->post('username'),
            'user_type'=>$this->input->post('user_type'),
            'email_address'=>$this->input->post('email_address'),
            'mobile_number'=>$this->input->post('mobile_number'),
            'created_at'=>date('Y-m-d H:i:s'),
        );

        $this->db->INSERT('users_tbl', $dataArr);
        $id = $this->db->insert_id();
        $this->generateUserID($id);
        $message = 'Added User ID#'.$id.' name: '.$this->input->post('fname').' '.$this->input->post('lname') ;
        $this->insertActivityLog($message); 
       }
    }
    public function generateUserID ($id, $length = 9) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $temp_id = '';
        for ($i = 0; $i < $length; $i++) {
            $temp_id .= $characters[rand(0, $charactersLength - 1)];
        }
        $rand = rand(1, 100);
        $user_id = '100'.$rand.$id.$temp_id;
        $dataArr = array('user_id'=>$user_id);
        $this->db->WHERE('id',$id)->UPDATE('users_tbl',$dataArr);
    }
    public function deleteUser() {
        if (isset($this->session->admin) || isset($this->session->staff) || isset($this->session->sys_admin)) {
            $user_data = $this->db->SELECT('user_id, username, user_type')->WHERE('user_id', $this->input->post('id'))->GET('users_tbl')->row_array();

            if ($this->session->user_id == $user_data['user_id']) {
                $response['status'] = 'error';
                $response['message'] = 'Action not allowed!';

                // activity logs
                $message = 'Deleting User Attempt. User ID#'.$user_data['user_id'].' Username: '.$user_data['username'].' User Type: '.$user_data['user_type'] ;
                $this->insertActivityLog($message);
            }
            else if (isset($this->session->staff) && $user_data['user_type'] == 'staff') {
                $response['status'] = 'error';
                $response['message'] = 'Action not allowed!';

                // activity logs
                $message = 'Deleting User Attempt. User ID#'.$user_data['user_id'].' Username: '.$user_data['username'].' User Type: '.$user_data['user_type'] ;
                $this->insertActivityLog($message);
            }
            else{
                // $this->db->WHERE('user_id', $this->input->post('id'))->DELETE('users_tbl');
                $response['status'] = 'success';
                $response['message'] = 'User '.$user_data['username'].' was successfully deleted!';
                
                // activity logs
                $message = 'Deleted User ID#'.$user_data['user_id'].' Username: '.$user_data['username'].' User Type: '.$user_data['user_type'] ;
                $this->insertActivityLog($message);
            }
            return $response;
      }
    }
    public function getData() {
        if (isset($this->session->admin) || isset($this->session->staff) || isset($this->session->sys_admin)) {
            $user_data = $this->db->SELECT('user_id, fname, lname, email_address, user_type, mobile_number, username')->WHERE('user_id', $this->input->get('id'))->GET('users_tbl')->row_array();
            return $user_data;
        }
    }
    public function editUser(){
        if (isset($this->session->user_id)) {
            $id = $this->input->post('user_id');
            if (isset($this->session->staff)) {
                $dataArr = array(
                    'fname'=>$this->input->post('fname'),
                    'lname'=>$this->input->post('lname'),
                    'username'=>$this->input->post('username'),
                    'email_address'=>$this->input->post('email_address'),
                    'mobile_number'=>$this->input->post('mobile_number'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                );
            }
            else if (isset($this->session->admin) || isset($this->session->sys_admin)){
                $dataArr = array(
                    'fname'=>$this->input->post('fname'),
                    'lname'=>$this->input->post('lname'),
                    'username'=>$this->input->post('username'),
                    'user_type'=>$this->input->post('user_type'),
                    'email_address'=>$this->input->post('email_address'),
                    'mobile_number'=>$this->input->post('mobile_number'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                );
            }

            $this->db->WHERE('user_id', $id)->UPDATE('users_tbl', $dataArr);

            $message = 'Updated User ID#'.$id.' name: '.$this->input->post('fname').' '.$this->input->post('lname') ;
            $this->insertActivityLog($message); 
        }
    }
     public function updateProfile(){
        if (isset($this->session->user_id)) {
            $id = $this->session->user_id;
            $dataArr = array(
                'fname'=>$this->input->post('fname'),
                'lname'=>$this->input->post('lname'),
                'username'=>$this->input->post('username'),
                'email_address'=>$this->input->post('email_address'),
                'mobile_number'=>$this->input->post('mobile_number'),
                'updated_at'=>date('Y-m-d H:i:s'),
            );

            $this->db->WHERE('user_id', $id)->UPDATE('users_tbl', $dataArr);

            $message = 'Updated User ID#'.$id.' name: '.$this->input->post('fname').' '.$this->input->post('lname') ;
            $this->insertActivityLog($message); 

            return $this->db->SELECT('fname,lname')->WHERE('user_id', $id)->GET('users_tbl')->row_array();
        }
    }
    public function checkEmail($email_address, $user_id){
        if (isset($this->session->user_id)) {
            return $this->db->WHERE('email_address', $email_address)
            ->WHERE_NOT_IN('user_id',$user_id)
            ->GET('users_tbl')->num_rows();
        }
        
    }
    public function checkUsername($username, $user_id){
        if (isset($this->session->user_id)) {
            return $this->db->WHERE('username', $username)
            ->WHERE_NOT_IN('user_id',$user_id)
            ->GET('users_tbl')->num_rows();
        }
    }
    public function checkMobileNUmber($mobile_number, $user_id){
        if (isset($this->session->user_id)) {
            return $this->db->WHERE('mobile_number', $mobile_number)
            ->WHERE_NOT_IN('user_id',$user_id)
            ->GET('users_tbl')->num_rows();
        }
    }
    public function updateImageProfile ($data) {
        if (isset($this->session->user_id)) {

            $this->db->WHERE('user_id',$this->session->user_id)->UPDATE('users_tbl',$data);
            $query = $this->db->SELECT('profile_image')->WHERE('user_id', $this->session->user_id)->GET('users_tbl')->row_array();

            return $query = base_url().$query['profile_image'];
        }
    }
    public function updateUserPassword () {
        if (isset($this->session->user_id)) {
            $dataArr = array('password'=>$this->hash_password($this->input->post('new_pass')), 'updated_at'=>date('Y-m-d H:i:s'));
            $this->db->WHERE('user_id', $this->session->user_id)->UPDATE('users_tbl',$dataArr);

            $message = 'Change Password. ID#'.$this->session->user_id.'.';
            $this->insertActivityLog($message); 

            $response['status'] = 'success';
            $response['message'] = 'Password successfully changed!';
            return $response;
        }
    }
    public function checkPassword () {
        if (isset($this->session->user_id)) {
            return $this->db->SELECT('password')->WHERE('user_id', $this->session->user_id)->GET('users_tbl')->row_array();
        }
    }
    public function resetPassword(){
        $id = $this->session->user_id;
        $password = '@kwartz'.date('Y');
        $dataArr = array(
            'password'=>$this->hash_password($password),
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        $this->db->WHERE('user_id', $id)->UPDATE('users_tbl', $dataArr);

        $message = 'Reset Password #'.$id.'.';
        $this->insertActivityLog($message); 

        $response['status'] = 'success';
        $response['message'] = 'Password successfully reset!';
        return $response;
    }
     public function resetPasswordViaEmail(){
        $id = $this->session->user_id;
        $password = '@kwartz'.date('Y');
        $dataArr = array(
            'password'=>$this->hash_password($password),
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        $this->db->WHERE('user_id', $id)->UPDATE('users_tbl', $dataArr);

        $message = 'Reset Password #'.$id.'.';
        $this->insertActivityLog($message); 

        $response['status'] = 'success';
        $response['message'] = 'Password successfully reset!';
        return $response;
    }
    public function resetPasswordViaEmailSent () {
        return $this->db->SELECT('user_id, email_address, username, mobile_number, fname, lname')
            ->WHERE('username', $this->input->post('user_email'))
            ->OR_WHERE('email_address', $this->input->post('user_email'))
            ->OR_WHERE('mobile_number', $this->input->post('user_email'))
            ->GET('users_tbl')->row_array();
    }
    public function checkRecoveryData ($id) {
        return $this->db->WHERE('user_id',$id)->WHERE('status','pending')->GET('recovery_tbl')->num_rows();
    }
    public function getUserDataFromSignature ($signature) {
        return $this->db->WHERE('signature',$signature)->WHERE('status','pending')->GET('recovery_tbl')->row_array();
    }
    public function updatePasswordFromRecovery () {
        if (isset($this->session->recovery_user_id)) {
            $dataArr = array('password'=>$this->hash_password($this->input->post('new_pass')), 'updated_at'=>date('Y-m-d H:i:s'));
            $this->db->WHERE('user_id', $this->session->recovery_user_id)->UPDATE('users_tbl',$dataArr);

            $recovey_data = array('status'=>'complete','updated_at'=>date('Y-m-d H:i:s'));
            $this->db->WHERE('user_id', $this->session->recovery_user_id)->UPDATE('recovery_tbl',$recovey_data);

            $message = 'Reset Password through recovery email.';
            $this->insertActivityLogResetPass($message); 

            $response['status'] = 'success';
            $response['message'] = 'Password successfully reset! You can now login!';
            return $response;
        }
    }
    public function getActivityLogs($row_per_page, $row_no){
        if (isset($this->session->user_id) && isset($this->session->admin) || isset($this->session->sys_admin)) {
            $search = $this->input->get('search');
            
            $query = $this->db->SELECT('fname, lname, username, message_log, ip_address, platform, browser, alt.created_at')
                ->FROM('activity_logs_tbl as alt')
                ->JOIN('users_tbl as ut','ut.user_id=alt.user_id')
                ->WHERE("(username LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR ip_address LIKE '%".$search."%' OR platform LIKE '%".$search."%' OR browser LIKE '%".$search."%' OR message_log LIKE '%".$search."%')", NULL, FALSE)
                ->LIMIT($row_per_page, $row_no)
                ->ORDER_BY('alt.created_at','desc')
                ->GET('')->result_array();
            
            $result = array();

            foreach($query as $q){
                $array = array(
                    'username'=>$q['username'],
                    'user'=>ucwords($q['fname'].' '.$q['lname']),
                    'message_log'=>$q['message_log'],
                    'ip_address'=>$q['ip_address'],
                    'platform'=>$q['platform'],
                    'browser'=>$q['browser'],
                    'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
                );
                array_push($result, $array);
            }
            return $result;
        }
    }
    public function getActivityLogCount(){
        if (isset($this->session->user_id) && isset($this->session->admin) || isset($this->session->sys_admin)) {
            $search = $this->input->get('search');
            $query = $this->db->FROM('activity_logs_tbl as alt')
                ->JOIN('users_tbl as ut','ut.user_id=alt.user_id')
                ->WHERE("(username LIKE '%".$search."%' OR fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR ip_address LIKE '%".$search."%' OR platform LIKE '%".$search."%' OR browser LIKE '%".$search."%' OR message_log LIKE '%".$search."%')", NULL, FALSE)
                ->GET('')->num_rows();
            return $query;
        }
    }
    public function resetPasswordByUserID () {
        if (isset($this->session->admin) || isset($this->session->staff) || isset($this->session->sys_admin)) {
            $user_id = $this->input->post('user_id');
            $password = $this->generateUserPassword();
            $user_data = $this->getUserDataByUserID($user_id);

            $dataArr = array('password'=>$this->hash_password($password), 'updated_at'=>date('Y-m-d H:i:s'));
            $this->db->WHERE('user_id', $user_id)->UPDATE('users_tbl',$dataArr);

            $message = 'Reset Password of User: @'.$user_data['username'].' through Admin Function.';
            $this->insertActivityLogResetPass($message); 

            $response['response']['status'] = 'success';
            $response['response']['message'] = 'Password successfully reset!';
            $response['user_data'] = $user_data;
            $response['user_data']['password'] = $password;
            return $response;
        }
    }
    public function generateUserPassword ($length = 9) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-';
        $charactersLength = strlen($characters);
        $temp_password = '';
        for ($i = 0; $i < $length; $i++) {
            $temp_password .= $characters[rand(0, $charactersLength - 1)];
        }
        return $temp_password;
    }
    public function getUserDataByUserID($user_id){
        if (isset($this->session->admin) || isset($this->session->staff) || isset($this->session->sys_admin)) {
            return $this->db->WHERE('user_id', $user_id)->GET('users_tbl')->row_array();
        }
    }
    public function insertDgateNotificationLog ($message) {
        if (isset($this->session->user_id)) {
            $activity_log = array(
                'user_id'=>'10009357526411', 
                'message_log'=>$message, 
                'ip_address'=>$this->input->ip_address(), 
                'platform'=>$this->agent->platform(), 
                'browser'=>$this->agent->browser(), 
                'created_at'=>date('Y-m-d H:i:s')
            ); 

            $this->db->INSERT('activity_logs_tbl', $activity_log);
        }
    }
}

