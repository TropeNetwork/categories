<?php
/**
 * @copyright  Copyright 2003
 * @author     Carsten Bleek <carsten@bleek.de>
 * @package    OpenHR
 * @version    $Revision: 1.1 $
 */

require_once(OPENHR_LIB. "/Database.php");

define ("CAT_LANGUAGE",       "language");
define ("CAT_CONTINENT",      "continent");
define ("CAT_COUNTRY",        "country");
define ("CAT_REGION",         "region");
define ("CAT_PROFESSION",     "profession");
define ("CAT_POSITION",       "position");
define ("CAT_INDUSTRY",       "industry");
define ("CAT_FIELD_OF_STUDY", "fieldOfStudy");
define ("CAT_JOBTYPE",        "jobtype");

define ("CAT_CODE_COUNTRY_ALPHA2",   "alpha2"); 
define ("CAT_CODE_COUNTRY_ALPHA3",   "alpha3"); 
define ("CAT_CODE_COUNTRY_NUMBER",   "number");
define ("CAT_CODE_COUNTRY_JOBPILOT", "jobpilot");
  
class Category {
    
    var $categories=array("language",
                          "region",
                          "profession",
                          "industry",
                          "fieldOfStudy");
    /**
     * defines, if categories are ordered
     **/
    var $_order="none";
    
    function Category (){
        $this->db=Database::getConnection( DB_CATEGORY );
    }

    /**
     * generates a list of key/value pairs
     *
     * @access public
     * @param  string $category  valid categories are:
     *                           - "language"
     *                           - "region"
     *                           - "country"
     *                           - "continent"
     *                           - "profession"
     *                           - "position"
     *                           - "industry"
     *                           - "jobtype"
     *                           - "fieldOfStudy"
     * @return array ("key"=>"value") 
     */
    function getChilds($category,$parent=NULL){
        switch($category){
        case CAT_LANGUAGE:
            return $this->_getLanguage();
            break;
        case CAT_CONTINENT:
            return $this->_getContinent();
            break;
        case CAT_COUNTRY:
            return $this->_getCountry($parent);
            break;
        case CAT_REGION:
            return $this->_getRegion($parent);
            break;
        case CAT_PROFESSION:
            return $this->_getProfession($parent);
            break;
        case CAT_POSITION:
            return $this->_getPosition();
            break;
        case CAT_INDUSTRY:
            return $this->_getIndustry($parent);
            break;
        case CAT_FIELD_OF_STUDY:
            return $this->_getFieldOfStudy($parent);
            break;
        default:
            return "unknown category";
        }
    }

    /**
     * defines, if the result should be returned in a certain order
     * @param string $order possible value "asc", "desc", "none"
     */
    function setOrder($order){
        $this->_order=$order;
    }

    function _getLanguage(){
        $query="SELECT code_iso639 AS name , name AS value FROM language WHERE code_jobpilot>0";
        return($this->_fetchResult($query));
    }

    /**
     * List of countries of a continent. If no Contentinent (parent_id)
     * is given, it return all countries worldwide.
     *
     * @param  string $coding Norm of the primary key.
     * @access private
     */
    function _getCountry($parent=null,$coding=CAT_CODE_COUNTRY_ALPHA2){

        if (!is_array($coding)) $coding=split(",",$coding);

        foreach ($coding AS $code){
            switch($code){
            case CAT_CODE_COUNTRY_ALPHA2:
                $fields[]="alpha_2";
                break;
            case CAT_CODE_COUNTRY_ALPHA3:
                $fields[]="alpha_2";
                break;
            case CAT_CODE_COUNTRY_NUMBER:
                break;
            case CAT_CODE_COUNTRY_JOBPILOT:
                $fields[]="jobpilot_region_id";
                break;
            default:
                $fields[]="alpha_2";
            }
            continue;
        }
        
        if (is_null($parent)){
            $query="SELECT country_id as name,
                           name AS value 
                      FROM country WHERE jobpilot_region_id>0";
        }else{
            $query="SELECT country_id as name,
                           name AS value 
                      FROM country
                     WHERE continent_id=$parent
                       AND jobpilot_region_id>0";
        }
        return($this->_fetchResult($query));
    }

    /**
     * regions of countries like Hesse or Bavaria in Germany
     *
     * @access private
     */
    function _getRegion($parent){
        $query="SELECT region_id AS name,
                       name AS value 
                  FROM region
                 WHERE country_id=$parent and jobpilot_region_id>0";
        return($this->_fetchResult($query));
    }

    /**
     * List of continents like North America, Europe, Austalia
     *
     * @access private
     */
    function _getContinent(){
        $query="SELECT continent_id AS name, name AS value FROM continent";
        return($this->_fetchResult($query));
    }

    /**
     * List of industries
     *
     * @access private
     */
    function _getIndustry($parent=null){
        if (is_null($parent)){
            $query="SELECT code_jobpilot AS name,text AS value FROM industries";
        }else{
            return("not implemented yet");
        }
        return($this->_fetchResult($query));
    }

    /**
     * List of field of studies
     *
     * @access private
     */
    function _getFieldOfStudy($parent=null){
        if (is_null($parent)){
            $query="SELECT code_jobpilot AS name,text AS value FROM fieldOfStudy";
        }
        return($this->_fetchResult($query));
    }

    /**
     * List of field of studies
     *
     * @access private
     */
    function _getPosition($parent=null){
        if (is_null($parent)){
            $query="SELECT code_ohr AS name,text AS value FROM position";
        }
        return($this->_fetchResult($query));
    }


    /**
     * List of industries
     *
     * @access private
     */
    function _getProfession($parent=null){
        if (is_null($parent)){
            $query="SELECT code_ohr AS name,text AS value FROM profession where length(code_ohr)=2";
        }else{
            return("not implemented yet");
        }
        return($this->_fetchResult($query));
    }

 
    /**
     * @access private
     */
    function _fetchResult(&$query){
        $result=$this->db->query($query);
        while($row=$result->fetchRow()){
            $array[$row["name"]]=_($row["value"]);
        }
        if ($this->_order=="desc"){
            asort($array);
        }
        return $array;
    }
}

?>