
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background: rgb(28,41,55);;
            color: #cccfd8 !important;
        }
    </style>
</head>
<body>
<?php
    echo 
    '<pre>' 
        .var_export($scanned_data, true). 
    '</pre>';
?>
<script src="<?=base_url('assets/js/jquery-3.6.3.min.js')?>"></script>
<?php if ($scanned_data['url_count'] > 0){ 
?>
    <script>
    base_url = "<?=base_url()?>";
    scanURL();
    function scanURL() {
        let api_key =  "AIzaSyCm_T4r1vS1qL-db7RKqjc22xg9OaYo-a8"; 
        let googleURL = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key="+api_key;
        let payload =
        {
            "client": {
              "clientId":      "shortlyapp382402",
              "clientVersion": "382402"
            },
            "threatInfo": {
              "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE", "CSD_DOWNLOAD_WHITELIST","POTENTIALLY_HARMFUL_APPLICATION","THREAT_TYPE_UNSPECIFIED"],
              "platformTypes":    ["ALL_PLATFORMS"],
              "threatEntryTypes": ["URL"],
              "threatEntries": [ <?= rtrim($url_to_scan,','); ?>
              ]
            }
        };
        $.ajax({
            url: googleURL,
            dataType: "json",
            type: 'POST',
            contentType: "application/js on; charset=utf-8",
            data: JSON.stringify(payload),
         })
         .done( (res) => {
            url_array = [];
            if(jQuery.isEmptyObject(res)){
                console.log('No unwanted URLs');
                activityLog('No unwanted URLs');
            }
            else {
                matches = res.matches;
                if (matches.length > 0) {
                    for(var i = 0; i < matches.length; i++){
                        url_array.push(matches[i].threat.url);
                    }
                    blockURL(url_array);
                }
            }
         })
         .fail(function(){
         })
    }

    function blockURL(url_array) {
        $.ajax({
		    url: base_url+'api/v1/url/_block_url',
			type: 'POST',
			dataType: 'JSON',
			data: {'url_array':url_array},
		})
		.done(function(res) {})
		.fail(function() {
			console.log("error");
		})
    }
    function activityLog(message) {
        $.ajax({
		    url: base_url+'api/v1/account/_new_activity_log',
			type: 'GET',
			dataType: 'JSON',
			data: {'message':message},
		})
		.done(function(res) {})
		.fail(function() {
			console.log("error");
		})
    }
    </script>  
<?php }?>   
</body>
</html>

