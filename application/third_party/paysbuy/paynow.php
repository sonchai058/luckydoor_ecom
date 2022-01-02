<?php

include("lib/nusoap.php");

$url = "https://www.paysbuy.com/api_paynow/api_paynow.asmx?WSDL";
$client = new nusoap_client($url, true);

$psbID = "Your PSBID";
$username = "Your PAYSBUY Account";
$secureCode = "Your Secure Code";
$inv = "Your Invoice";
$itm = "Description of product";
$amt = "Price of product";
$paypal_amt = "Price of product (US Dolla Only)";
$curr_type = "TH";
$com = "";
$method = "6"; //6 for Counter Service
$language = "T";

//Change to your URL
$resp_front_url = "URL of frontend process";
$resp_back_url = "URL of backend process";

//Optional data
$opt_fix_redirect = "1"; //autu-redirect to Merchant
$opt_fix_method = "1"; // Show only CS
$opt_name = "";
$opt_email = "";
$opt_mobile = "";
$opt_address = "";
$opt_detail = "";

$result = "";

//1. Step 1 call method api_paynow_authentication
$params = array("psbID"=>$psbID, "username"=>$username, "secureCode"=>$secureCode, "inv"=>$inv, "itm"=>$itm, "amt"=>$amt, "paypal_amt"=>$paypal_amt, "curr_type"=>$curr_type, "com"=>$com, "method"=>$method, "language"=>$language, "resp_front_url"=>$resp_front_url, "resp_back_url"=>$resp_back_url, "opt_fix_redirect"=>$opt_fix_redirect, "opt_fix_method"=>$opt_fix_method, "opt_name"=>$opt_name, "opt_email"=>$opt_email, "opt_mobile"=>$opt_mobile, "opt_address"=>$opt_address, "opt_detail"=>$opt_detail);

$result = $client->call('api_paynow_authentication_new', array('parameters' => $params), 'http://tempuri.org/', 'http://tempuri.org/api_paynow_authentication_new', false, true);

if ($client->getError()) {
    echo "<h2>Constructor error</h2><pre>" . $client->getError() . "</pre>";
} else {
    $result = $result["api_paynow_authentication_newResult"];
}
echo "<br>result ->".$result;

$approveCode = substr($result,0,2);

echo "<br>approveCode->".$approveCode;

$intLen = strlen($result);
$strRef = substr($result,2, $intLen-2);

//2. If authentication is successful, then the server responds 00, The process continues redirect to PAYSBUY API Page.
if($approveCode=="00") {
    echo "<meta http-equiv='refresh'
content='0;url=https://www.paysbuy.com/paynow.aspx?refid=".$strRef."'>";
} else {
    echo "<br>Can't login to paysbuy server";
}
?>