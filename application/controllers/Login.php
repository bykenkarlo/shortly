<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Login extends CI_Controller {

	function __construct (){
        parent::__construct();
		$this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->load->model('User_model');
        $this->load->model('Login_model');
    }
    public function loginProcess() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $remember_login = $this->input->post('remember_login');
        $last_url = $this->input->post('last_url');

        if (isset($remember_login) ) {
            $cookie_name = 'remember_login';
            $cookie_value = $remember_login;
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 30 days
        }
        else{
            $remember_login = '';
        }

        $checkUser = $this->Login_model->checkUserData($username);
        if (isset($checkUser)) {
            if ($checkUser['status'] == 'disabled') {
                $response['status'] = 'error';
                $response['message'] = 'User status is Disabled! Contact our Support to enable your account!';
            }
            else if ($checkUser['user_type'] == 'user') {
                $this->session->set_userdata('secret_key', $checkUser['secret_key']);
               /* INSERT new remember token */ 
                $this->Login_model->insertNewRememberLogin($remember_login);
                    
                $message = 'User Logged in.';
                $this->User_model->insertActivityLog($message); 
                $response['status'] = 'success';
                $response['message'] = 'Logging in! Please wait...';
                $response['url'] = base_url('logged/dashboard');
            }
            else if (password_verify($password, $checkUser['password'])) {
                if ($last_url != '') {
                    $response['url'] = base_url().$last_url;
                }
                // else if($checkUser['user_type'] == 'user'){
                //     $this->session->set_userdata('secret_key', $checkUser['secret_key']);
                //      /* INSERT new remember token */ 
                //      $this->Login_model->insertNewRememberLogin($remember_login);
                    
                //      $message = 'User Logged in.';
                //      $this->User_model->insertActivityLog($message); 
                //     $response['url'] = base_url('logged/dashboard');
                // }
                else  if($checkUser['user_type'] == 'admin'){
                    $this->session->set_userdata('user_id', $checkUser['user_id']);
                    $this->session->set_userdata($checkUser['user_type'], $checkUser['user_type']);
                    $this->session->set_userdata('username', $checkUser['username']);

                    /* INSERT new remember token */ 
                    $this->Login_model->insertNewRememberLogin($remember_login);
                    
                    $message = 'Logged in.';
                    $this->User_model->insertActivityLog($message); 

                    $response['url'] = base_url('account/dashboard');
                }

                $response['status'] = 'success';
                $response['message'] = 'Logging in! Please wait...';
            }
            else{
                $response['status'] = 'error';
                $response['message'] = 'Wrong password! Try again!';
            }
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'No user found! Try again!';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function loggedUserByAdmin($username) {
        if(isset($this->session->admin)){
            $check_user = $this->User_model->getUserDataByUsername($username);
            if(!empty($check_user)){
                $this->session->set_userdata('secret_key', $check_user['secret_key']);
                /* INSERT new remember token */ 
                            
                $message = 'User Logged in by Admin.';
                $this->User_model->insertActivityLog($message); 
                header('Location:'. base_url('logged/dashboard'));
            }
            else{
                $this->Site_settings_model->error404();
            }
        }
    }
    public function userSecretLogin($secret_key) {
        $session = array(
            'secret_key', 
        );
        $this->session->unset_userdata($session);
        $checkUser = $this->Login_model->checkUserData($secret_key);
        if (isset($checkUser)) {
            if ($checkUser['status'] == 'disabled') {
                header('Location:'.base_url());
            }
            else if (!empty($checkUser)) {
                $this->session->set_userdata('secret_key',$secret_key);
                header('Location:'.base_url('logged/dashboard'));
            }
            else{
                header('Location:'.base_url());
            }
        }
        else{
            header('Location:'.base_url());
        }
    }
}