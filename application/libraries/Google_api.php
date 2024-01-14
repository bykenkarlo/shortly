

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_api {

    public function authKeys() {
        $auth = array(
            'api_key' => 'api_key_here',
            'google_safe_url' => "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=",
        );
        return $auth;
    }
}
