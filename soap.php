<?php
define("FILE_INI", "/home/carsten/config/OpenHR.conf");
define("PEAR_BASE","/home/carsten/external/pear");
define("OPENHR_LIB","/home/carsten/public_html/jobAdmin/lib");

ini_set("include_path",".:".PEAR_BASE);

require_once('SOAP/Server.php');
require_once(OPENHR_LIB."/Category.php");

$ss = new SOAP_Server();

$ss->addObjectMap(new SOAP_category, 'urn:SOAP_category');
$ss->service($HTTP_RAW_POST_DATA);

class SOAP_category{

    function get($category,$parent){
        $cat=new Category;
        return $cat->getChilds($category,$parent);
    }

    function resolve($category,$key){
        $cat=new Category;
        return $cat->getChilds("language");
    }

}


?>