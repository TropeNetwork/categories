<?php

require_once('SOAP/Server.php');

$ss = new SOAP_Server();
$sc = new SOAP_job();

$ss->addObjectMap($sc, 'urn:SOAP_job');

$ss->service($HTTP_RAW_POST_DATA);

// Sample SOAP Class
class SOAP_job{
    function activate($job_id, $data){
        return ("activate job $job_id");

    }
    
    function test_soap($p_one, $p_two)
    {
        return "You sent p_one='$p_one' & p_two='$p_two'\n";
    }
}
?>