<?php

#error_reporting( E_ALL );
// SOAP TEST
require_once("SOAP/Client.php");

$ini=parse_ini_file("/home/carsten/config/categories.conf");

$endpoint     = $ini["soap.search_server"];

print "<h1>$endpoint</h1>";
$wsdl         = false;
$portName     = false;
$proxy_params = array();

$sc = new SOAP_Client($endpoint);
$sc->setErrorHandling(PEAR_ERROR_PRINT);

$method  = 'get';
$params  = array("category" => "language");
$options = array('namespace' => 'urn:SOAP_category',
                 'trace'     => true,
                 'timeout'   => 10);
$res     = $sc->call($method, $params, $options);

print "<hr>".$sc->headersOut."</hr><hr>".$sc->headersIn;
print "<pre>".htmlspecialchars($sc->__get_wire())."</pre>";
print_r($res);


?>
