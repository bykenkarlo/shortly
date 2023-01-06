<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_kit {

    public function authKeys() {
        $auth = array(
            'public_key'=>'public_EUZyJtv7nvrXsy301n9PjKOdW7I=',
            'private_key'=>'private_7zWxit4pud4NqSFaKYcpHH9suNc=',
            'end_point_url'=>'https://ik.imagekit.io/shortly/',
        );
        return $auth;
    }
}
