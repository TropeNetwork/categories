<?php
define("FILE_INI", "/home/carsten/config/jobAdmin.conf");
define("PEAR_BASE","/home/carsten/public_html/pear");
define("OPENHR_LIB","/home/carsten/public_html/jobs/lib");

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