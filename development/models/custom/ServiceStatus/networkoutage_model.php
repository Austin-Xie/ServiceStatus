<?php
// namespace Custom\Models;
use RightNow\Connect\v1 as RNCPHP;

class NetworkOutage_model extends Model
{
    function __construct()
    {
        parent::__construct();
        require_once(get_cfg_var('doc_root')."/ConnectPHP/Connect_init.php");
        initConnectAPI();
    }

   /**
    * Returns CO.NetworkOutage objects from the database based on their status and suburb.
    *
    * @param $suburb String The suburb names
    * @param $status String The status of CO.NetworkOutage objects.
    *
    * @return Answer The CO.NetworkOutage with the specified answer_id
    */
    function getBySuburb($suburb, $status){

        $nos = RNCPHP\ROQL::queryObject("SELECT CO.NetworkOutage FROM CO.NetworkOutage WHERE ProcessStatus.Name = '"
              . $status . "' AND Areas like '%" . $suburb . "%'")->next();

        return $nos;
    }

    /**
    * Returns an CO.NetworkOutage object from the database based on its id
    *
    * @param $serviceStatusId Int The ID for CO.NetworkOutage 
    *
    * @return CO.NetworkOutage  The CO.NetworkOutage object with its details
    */
    function getNetworkOutageById($serviceStatusId) {
        $no = RNCPHP\ROQL::queryObject("SELECT CO.NetworkOutage FROM CO.NetworkOutage WHERE  ID = " 
              . $serviceStatusId)->next();

        return $no;
    }

}
 