<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GoogleApi_model extends CI_Model {
    public function safeBrowsingApi($url_array){
        $api_key = 'AIzaSyCm_T4r1vS1qL-db7RKqjc22xg9OaYo-a8'; 
        $request_data = array(
            "client"=> array(
                "clientId" => "shortlyapp382402",
                "clientVersion" => "382402"
            ),
            "threatInfo"=>array(
                "threatTypes"=>array("MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE", "CSD_DOWNLOAD_WHITELIST","POTENTIALLY_HARMFUL_APPLICATION","THREAT_TYPE_UNSPECIFIED"),
                "platformTypes"=>array("ALL_PLATFORMS"),
                "threatEntryTypes"=>array("URL"),
                "threatEntries"=>$url_array
            )
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=".$api_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,3,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_CAINFO => 'ca-bundle.crt', /* problem here! */
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