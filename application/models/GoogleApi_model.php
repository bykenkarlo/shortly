<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GoogleApi_model extends CI_Model {
    public function safeBrowsingApi($url_to_scan){
        $google_api = $this->google_api->authKeys();
        $result = "";
        $api_key = 'AIzaSyDck2wgJU_lerRlt8WHCOo8aQnb01AKpYo';
        $api_url = $google_api['google_safe_url'] . $google_api['api_key'] ;
        $request_data = [
            'client' => [
                'clientId' => 'shortlyapp382402',
                'clientVersion' => '382402',
            ],
            'threatInfo' => [
                'threatTypes' => ["MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE", "CSD_DOWNLOAD_WHITELIST","POTENTIALLY_HARMFUL_APPLICATION","THREAT_TYPE_UNSPECIFIED"],
                'platformTypes' => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [
                     ['url'=>"".$url_to_scan.""]
                ],
            ],
        ];
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_REFERER, base_url());
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));
        $response = curl_exec($ch);
        if (curl_errno($ch)) 
        {
            $curl_message = "cURL error: " . curl_error($ch);
            // $this->Shortener_model->insertActivityLog($curl_message);
        } 
        else 
        {
            $curl_message = "";
            $result = json_decode($response, true);
            // if (isset($result['matches']) && !empty($result['matches'])) 
            // {
            //     foreach($result['matches'] as $match){
            //         $array = array(
            //             "url"=>$match['threat']['url'],
            //         );
            //         array_push($blocked_url, $array);
            //     }
            // } 

        }
        curl_close($ch);
        return $result;
    }
}