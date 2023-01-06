<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csrf_model extends CI_Model {

	public function getCsrfData() {
		$data = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        return $data;
	}
}