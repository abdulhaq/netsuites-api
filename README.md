
# PHP NetSuite APIs

Been working with APIs from last 10 years, I can say that NetSuite APIs are by far the most complex ones to work with. I spend weeks upon weeks to learn how to work with them and decided to share my code here so it maybe of help you anyone and save them the time it took me to get started.

## Environment Variables

You will need NetSuite API keys to be able to access data from NetSuite. Add following variables in **config.php** file.

`endpoint` 

This is something like `2020_2`

`host`

Link of your APIs. E.g. `https://xxxxxx.suitetalk.api.netsuite.com`

`account`

The account id for your NetSuite. E.g. `xxxxx_SB`

`signatureAlgorithm`

This tells which encryption algorithm to use. You can use `sha256`

`consumerKey`

Your Consumer key

`consumerSecret`

Your Consumer Secret

`token`

Access token for your API user

`tokenSecret`

Access Token secret for your API user
## Installation

You will need to install [PHP NetSuite library](https://github.com/netsuitephp/netsuite-php). If you use composer, you can run following command:
```
composer require ryanwinchester/netsuite-php
```
After that use the following code 
```
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
```