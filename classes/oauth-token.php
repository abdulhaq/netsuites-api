<?php

define("NETSUITE_DEPLOYMENT_URL", 'https://xxxxxx.restlets.api.netsuite.com/app/site/hosting/restlet.nl?script=103&deploy=1');
define("NETSUITE_URL", 'https://xxxxxx.restlets.api.netsuite.com');
define("NETSUITE_REST_URL", 'https://xxxxxx.restlets.api.netsuite.com/app/site/hosting/restlet.nl');
define("NETSUITE_SCRIPT_ID", '103');
define("NETSUITE_DEPLOY_ID", '1');
define("NETSUITE_ACCOUNT", 'xxxxxx');

define("NETSUITE_CONSUMER_KEY", 'xxxxxxxxxxxxxxxxx');
define("NETSUITE_CONSUMER_SECRET", 'xxxxxxxxxxxxxxxxx');
define("NETSUITE_TOKEN_ID", 'xxxxxxxxxxxxxxxxx');
define("NETSUITE_TOKEN_SECRET", 'xxxxxxxxxxxxxxxxx');


function oauth_token()
{
    $oauth_nonce = md5(mt_rand());
    $oauth_timestamp = time();
    $oauth_signature_method = 'HMAC-SHA256';
    $oauth_version = "1.0";
    $method = 'POST';

    $base_string =
        $method . "&" . urlencode(NETSUITE_REST_URL) . "&" .
        urlencode(
            "deploy=" . NETSUITE_DEPLOY_ID
                . "&oauth_consumer_key=" . NETSUITE_CONSUMER_KEY
                . "&oauth_nonce=" . $oauth_nonce
                . "&oauth_signature_method=" . $oauth_signature_method
                . "&oauth_timestamp=" . $oauth_timestamp
                . "&oauth_token=" . NETSUITE_TOKEN_ID
                . "&oauth_version=" . $oauth_version
                . "&script=" . NETSUITE_SCRIPT_ID
        );

    $key = rawurlencode(NETSUITE_CONSUMER_SECRET) . '&' . rawurlencode(NETSUITE_TOKEN_SECRET);
    $signature = base64_encode(hash_hmac("sha256", $base_string, $key, true));
    $auth_header = 'OAuth '
        . 'realm="' . rawurlencode(NETSUITE_ACCOUNT) . '",'
        . 'oauth_consumer_key="' . rawurlencode(NETSUITE_CONSUMER_KEY) . '",'
        . 'oauth_token="' . rawurlencode(NETSUITE_TOKEN_ID) . '",'
        . 'oauth_signature_method="' . rawurlencode($oauth_signature_method) . '",'
        . 'oauth_timestamp="' . rawurlencode($oauth_timestamp) . '",'
        . 'oauth_nonce="' . rawurlencode($oauth_nonce) . '",'
        . 'oauth_version="' . rawurlencode($oauth_version) . '",'
        . 'oauth_signature="' . rawurlencode($signature) . '"';

        return $auth_header;
}
