<?php

define('EDIT_TEXT', 1);

include_once "prepend.inc";
include_once OPENHR_LIB."/Database.php";
include_once OPENHR_LIB."/Category.php";
include_once "menu.inc";


$page=&Page::singleton("categories");
Page::fetchSlots("categories");
Page::setSlot('menuleft',    menuleft());
Page::setSlot('menutop',     menutop());
Page::setSlot('menufoot',    sprintf(_("Copyright (c) 2003 %s"),"<a href=\"?content=carsten\">Carsten Bleek</a>"));

$template_dir="categories/";


// SOAP TEST
require_once("SOAP/Client.php");

$ini=parse_ini_file(FILE_INI);

$endpoint     = $ini["soap.search_server"];

print "<h1>$endpoint</h1>";
$wsdl         = false;
$portName     = false;
$proxy_params = array();

$sc = new SOAP_Client($endpoint);
$method  = 'get';
$params  = array("category" => "language");
$options = array('namespace' => 'urn:SOAP_category');
$res     = $sc->call($method, $params, $options);
print_r($res);

$soap["request"]  ="request";
#var_export($sc->xml,true);
$soap["response"] ="response";

$smarty->assign("daten","daten");
$smarty->assign("SOAP",$soap);
$smarty->assign("page",Page::getSlots());

$smarty->display($template_dir.'generic.tpl');


?>
