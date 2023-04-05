<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('Google_app_api');
    }
    public function safeBrowsingApi(){
        // : Production
        $url = $this->input->post('url');
        $auth = $this->google_app_api->authKeys(); 
        $paynamics_keys =  base64_encode($auth['PNM_AUTH_USER'].':'.$auth['PNM_AUTH_USER_PASS']);
        $request_data = '
        {
            "client": {
              "clientId":      "shortly-app-382402 ",
              "clientVersion": "1.5.2"
            },
            "threatInfo": {
              "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING"],
              "platformTypes":    ["WINDOWS"],
              "threatEntryTypes": ["URL"],
              "threatEntries": [
                {"url": '.$url.'},
              ]
            }
          }
        
        ';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=" . $auth['api_key'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,3,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request_data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}