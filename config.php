<?php
$config = [
    // required -------------------------------------
    "endpoint"       => "2021_1",
    "host"           => "https://webservices.netsuite.com",
    "account"        => "MYACCT1",
    "consumerKey"    => "0123456789ABCDEF",
    "consumerSecret" => "0123456789ABCDEF",
    "token"          => "0123456789ABCDEF",
    "tokenSecret"    => "0123456789ABCDEF",
    // optional -------------------------------------
    "signatureAlgorithm" => 'sha256', // Defaults to 'sha256'
    "logging"  => true,
    "log_path" => "/var/www/myapp/logs/netsuite",
    "log_format"     => "netsuite-php-%date-%operation",
    "log_dateformat" => "Ymd.His.u",
];

require_once 'vendor/autoload.php';

$service = new NetSuiteService($config);