<?php

// quick webinterface hack in order to click through categories

include_once "prepend.inc";
include_once OPENHR_LIB."/Database.php";
include_once OPENHR_LIB."/Category.php";
include_once "menu.inc";

$category = getGet("category",CAT_LANGUAGE);
$parent   = getGet("parent","");
$output   = getGet("output","");

$_PEAR_default_error_mode=PEAR_ERROR_TRIGGER;
PEAR::setErrorHandling(PEAR_ERROR_DIE);
$page=&Page::singleton("");
$page->setSlot('location', sprintf(_("SOAP Anfrage für %s"),$category));
$page->setSlot('menuleft',    menuleft());
$page->setSlot('menutop',     menutop());
$page->setSlot('menufoot',    sprintf(_("Copyright (c) 2003 %s"),"<a href=\"?content=carsten\">Carsten Bleek</a>"));

$template_dir="categories/";

// SOAP TEST
require_once("SOAP/Client.php");

$endpoint     = $OHR_CONFIG["soap.category"];

$wsdl         = false;
$portName     = false;
$proxy_params = array();

$sc = new SOAP_Client($endpoint);

$method  = 'get';

$params  = array("category" => $category,
                 "parent"   => $parent);

$options = array('namespace' => 'urn:SOAP_category',
                 'trace'     => $output!="html",
                 'timeout'   => 20);

$data     = $sc->call($method, $params, $options);

$smarty->assign("category",$category);
$smarty->assign("parent",$parent);
$smarty->assign("data",$data);
$smarty->assign("content",$template_dir."request.tpl");

if ($output=="html"){
     $template=$template_dir.$category.".tpl";
}else{
    list($soap["request"] ,
         $soap["response"]) = split("INCOMING\n\n",$sc->__get_wire());
    $soap["request"]=substr($soap["request"],11);
    $smarty->assign("SOAP",$soap);
    $template = 'generic.tpl';
    $html     = $smarty->fetch($template_dir.'request.tpl');
    $page->setSlot("content",$html);
}

$page->toHtml(array("template"=>$template)); 
?>