<?php
    require "../vendor/autoload.php";
    $archiveId          = $_GET['ref'];
    $apiKey             = "46472052";
    $apiSecret          = "94f02730f0dfc50d5696e81d4d96ead0e038b9d5";
    // use OpenTok\OpenTok;

    // Create token header as a JSON string
    $header = json_encode(
        [
            'typ' => 'JWT', 
            'alg' => 'HS256'
        ]
    );
    // Create token payload as a JSON string
    $payload            = json_encode(
        [
            'iss'=>$apiKey,
            'iat'=>time(),
            'exp'=>time() + (3600 * 3),
            'ist'=>'xClass',
            'jti'=>'shams',
        ]
    );
    // Encode Header to Base64Url String
    $base64UrlHeader    = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    // Encode Payload to Base64Url String
    $base64UrlPayload   = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    // Create Signature Hash
    $signature          = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, '94f02730f0dfc50d5696e81d4d96ead0e038b9d5', true);
    // Encode Signature to Base64Url String
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    // Create JWT
    $jwt                = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    // $opentok = new OpenTok($apiKey, $apiSecret);

    // use OpenTok\MediaMode;
    // use OpenTok\ArchiveMode;
    // use OpenTok\Session;
    // use OpenTok\Role;

    // $archive = $opentok->getArchive($archiveId);
    // print_r($archive);
    //step1
    $cSession   = curl_init(); 
    //step2
    curl_setopt($cSession, CURLOPT_URL,"https://api.opentok.com/v2/project/$apiKey/archive/$archiveId");
    curl_setopt($cSession, CURLOPT_RETURNTRANSFER,true);
    // curl_setopt($cSession, CURLOPT_HEADER, true); 
    curl_setopt($cSession, CURLOPT_HTTPHEADER, array(
        'X-OPENTOK-AUTH: '.$jwt
        // 'X-TB-PARTNER-AUTH: 94f02730f0dfc50d5696e81d4d96ead0e038b9d5'
    ));

    //step3
    $result     = curl_exec($cSession);
    //step4
    curl_close($cSession);
    //step5
    print_r($result);