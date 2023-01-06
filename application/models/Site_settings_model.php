<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_settings_model extends CI_Model {

	public function siteSettings(){
		return $this->db->GET('site_settings_tbl')->row_array();
	}
    public function getSocialMedias() {
        $query = $this->db->SELECT('id, social_media, handle, created_at')
            ->ORDER_BY('created_at','asc')
            ->GET('social_media_handles_tbl')->result_array();
        $result = array();
        foreach ($query as $v) {
           if ($v['social_media'] == 'facebook') {
                  $handle = 'https://facebook.com/'.$v['handle'];
           }
              if ($v['social_media'] == 'instagram') {
                  $handle = 'https://instagram.com/'.$v['handle'];
           }
              if ($v['social_media'] == 'twitter') {
                  $handle = 'https://twitter.com/'.$v['handle'];
           }
              if ($v['social_media'] == 'tiktok') {
                  $handle = 'https://tiktok.com/'.$v['handle'];
               }
           if ($v['social_media'] == 'github') {
                  $handle = $v['handle'];
           }
           if ($v['social_media'] == 'linkedin') {
                  $handle = 'https://linkedin.com/company/'.$v['handle'];
           }
              $array = array(
               'social_media'=>$v['social_media'],
               'handle'=>$handle,
              );
        array_push($result, $array);
        }
        return $result;
    }
    public function generateNonce($length = 17) {
		$characters = '0123456789abcdef';
	    $charactersLength = strlen($characters);
	    $nonce = '';
	    for ($i = 0; $i < $length; $i++) {
	        $nonce .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $this->session->set_userdata('nonce', $nonce);
    	return $nonce;
   }
   public function error404() {
        $data['siteSetting'] = $this->Site_settings_model->siteSettings();
        $data['social_media'] = $this->Site_settings_model->getSocialMedias();
        $data['title'] = 'index';
        $data['description'] = 'this is the description';
        $data['canonical_url'] = base_url();
        $data['state'] = "error404";
        $data['url_param'] = "";
        $data['csrf_data'] = $this->Csrf_model->getCsrfData();
    	$this->load->view('home/nav', $data);
    	$this->load->view('errors/error_404');
    	$this->load->view('home/footer');
   }

}