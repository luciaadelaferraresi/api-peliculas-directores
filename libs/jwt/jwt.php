<?php


define('JWT_SECRET', 'mi1secreto');


function createJWT($payload) {
    
    $header = json_encode([
        'typ' => 'JWT',
        'alg' => 'HS256'
    ]);

   
    $base64UrlHeader = base64UrlEncode($header);
    $base64UrlPayload = base64UrlEncode(json_encode($payload));

   
    $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", JWT_SECRET, true);
    $base64UrlSignature = base64UrlEncode($signature);

   
    return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";
}


function validateJWT($jwt) {
    $parts = explode('.', $jwt);
    if (count($parts) !== 3) {
        return null;
    }

    list($header, $payload, $signature) = $parts;

   
    $valid_signature = hash_hmac('sha256', "$header.$payload", JWT_SECRET, true);
    $valid_signature = base64UrlEncode($valid_signature);


    if (!hash_equals($signature, $valid_signature)) {
        return null; 
    }

    $payload = json_decode(base64_decode(strtr($payload, '-_', '+/')));

  
    if (!isset($payload->exp) || $payload->exp < time()) {
        return null;
    }

    return $payload;
}


function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}