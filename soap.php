<?php

require_once("prepend.inc");
require_once('SOAP/Server.php');
require_once(OPENHR_LIB."/Category.php");

$ss = new SOAP_Server();

$ss->addObjectMap(new SOAP_category, 'urn:SOAP_category');

$ss->service($HTTP_RAW_POST_DATA);

class SOAP_category{
    function get($category){
        $cat=new Category;
        return $cat->getChilds("language");
    }

    function resolve($category,$key){
        $cat=new Category;
        return $cat->getChilds("language");
    }

}


?>