<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GoogleApi_model extends CI_Model {
    public function safeBrowsingApi(){
        $url = $this->input->post('long_url');
        $auth = $this->google_app_api->authKeys(); 
        $request_data = array(
            "client"=> array(
                "clientId"=>"shortly",
                "clientVersion"=> "1.0"
            ),
            "threatInfo"=>array(
                "threatTypes"=>array("MALWARE","SOCIAL_ENGINEERING"),
                "platformTypes"=>array("ALL_PLATFORMS"),
                "threatEntryTypes"=>array("URL"),
                "threatEntries"=>array(
                    "url"=>$url
                )
            )
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=".$auth['api_key'],
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