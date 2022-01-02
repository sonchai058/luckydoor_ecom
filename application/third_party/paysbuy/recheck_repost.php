<?php

include("lib/nusoap.php");
$url = "https://www.paysbuy.com/psb_ws/getTransaction.asmx?WSDL";
$client = new nusoap_client($url, true);

$psbID = ""; 

$biz = "";

$secureCode = "";

$invoice = "";

$params = array("psbID"=>$psbID,"biz"=>$biz,"secureCode"=>$secureCode,"invoice"=>$invoice,"flag"=>$flag);

echo $result;

$result = $client->call('getTransactionByInvoiceCheckPost',array('parameters' => $params),'http://tempuri.org/','http://tempuri.org/getTransactionByInvoiceCheckPost',false,true);

if ($client->getError()) {
    echo "<h2>Constructor error</h2><pre>" . $client->getError() . "</pre>";
} else {
    $result = $result["getTransactionByInvoiceCheckPostResult"];
}

$result_a = $result["getTransactionByInvoiceReturn"]["result"]."<br>";
$result_b = $result["getTransactionByInvoiceReturn"]["Invoice"]."<br>";
$result_c = $result["getTransactionByInvoiceReturn"]["apCode"]."<br>";
$result_d = $result["getTransactionByInvoiceReturn"]["amt"]."<br>";
$result_e = $result["getTransactionByInvoiceReturn"]["fee"]."<br>";
$result_f = $result["getTransactionByInvoiceReturn"]["method"]."<br>";

echo $result_a.$result_b.$result_c.$result_d.$result_e.$result_f;


?>