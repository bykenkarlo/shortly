<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('Google_app_api');
    }
    public function safeBrowsingApi(){
        // Your Google Safe Browsing API key
        $api_key = 'AIzaSyCm_T4r1vS1qL-db7RKqjc22xg9OaYo-a8';

        // URL to check
        $url_to_check = 'https://example.com';

        // Google Safe Browsing API endpoint
        $api_url = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $api_key;

        // Create request body
        $request_data = [
            'client' => [
                'clientId' => 'YourAppName',
                'clientVersion' => '1.0.0',
            ],
            'threatInfo' => [
                'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                'platformTypes' => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [
                    ['url' => $url_to_check],
                ],
            ],
        ];

        // Initialize cURL session
        $ch = curl_init($api_url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));

        // Execute cURL session
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            // Handle the error appropriately
        } else {
            // Decode the JSON response
            $result = json_decode($response, true);

            // Check if the URL is flagged as a threat
            if (isset($result['matches']) && !empty($result['matches'])) {
                echo 'The URL is flagged as a threat.';
                // Take appropriate action, such as blocking the URL
            } else {
                echo 'The URL is safe.';
                // Proceed with normal operation
            }
        }

        // Close cURL session
        curl_close($ch);

    }
}