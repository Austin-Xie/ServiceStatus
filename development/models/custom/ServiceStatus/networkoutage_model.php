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

	function getNTs() {
		$nt = RNCPHP\ROQL::query("SELECT nt.Name, nt.ID FROM CO.NwkOtgType nt ")->next();
		return $nt;
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
        $rowLimit = 20;
	    $serviceStatusQry = "SELECT no.ID, no.OptusNetworkRef, no.State, no.Areas, no.CustomService," .
		                    " no.CustomSummary, no.Type, no.StartTime, no.EndTime, no.FixingStatus" .
                            " FROM CO.NetworkOutage no WHERE ProcessStatus = 3"; //'"
		                    //. $status . "' ";
        if (empty($suburb)) {
            $nos = RNCPHP\ROQL::query($serviceStatusQry . " LIMIT " . $rowLimit)->next();
        } else {
		    $nos = RNCPHP\ROQL::query($serviceStatusQry . " AND Areas like '%" . $suburb . "%'"
			                          . " LIMIT " . $rowLimit)->next();
        }

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
	    $rowLimit = 20;
	    $serviceStatusQry = "SELECT no.ID, no.OptusNetworkRef, no.State, no.Areas, no.CustomService," .
		                    " no.CustomSummary, no.Type, no.StartTime, no.EndTime, no.FixingStatus" .
							" no.UpdatedTime, no.CustomDescription, no.Resolution " .
                            " FROM CO.NetworkOutage no WHERE  ID = ". $serviceStatusId .
							" LIMMIT " . $rowLimit .
							" ORDER BY no.StartTime DESC";
							
        //$no = RNCPHP\ROQL::queryObject("SELECT CO.NetworkOutage FROM CO.NetworkOutage WHERE  ID = " 
        //      . $serviceStatusId)->next();
		$no = RNCPHP\ROQL::query(serviceStatusQry)->next();

        return $no;
    }

    /**
    * Returns an CO.NwkOtgTemplate object from the database based on its id
    *
    * @param $templateId Int The ID for CO.NwkOtgTemplate
    *
    * @return CO.NwkOtgTemplate  The CO.NwkOtgTemplate object with its details
    */

    function getNetworkOutageTemplateById($templateId) {
        $noTmpl = RNCPHP\ROQL::queryObject("SELECT CO.NwkOtgTemplate FROM CO.NwkOtgTemplate WHERE  ID = "
                  . $templateId)->next();

        return $noTmpl;
    }

    function populateNwkOtgTemplate($noTmpl, $ssJsonTemplate) {
        $noTmpl->NetworkType = $ssJsonTemplate->NetworkType;
        $noTmpl->OptusNetwork = $ssJsonTemplate->OptusNetwork;
        $noTmpl->OptusService = $ssJsonTemplate->OptusService;
        $noTmpl->PlanType = $ssJsonTemplate->PlanType;
        $noTmpl->OutageType = $ssJsonTemplate->OutageType;
        $noTmpl->ProductRename = $ssJsonTemplate->ProductRename;
        $noTmpl->Severity = $ssJsonTemplate->Severity;
        $noTmpl->Summary = $ssJsonTemplate->Summary;
        $noTmpl->Description = $ssJsonTemplate->Description;
    }

    function updateNwkOtgTemplate($ssJsonTemplate) {
        $noTemple = null;
        if (is_null($ssJsonTemplate->ID)) {
             $noTemple = new RNCPHP\CO.NwkOtgTemplate;
        } else {
             $noTemple =  getNetworkOutageTemplateById($ssJsonTemplate->ID);
        }

        if(is_null($noTemple)) {
            return 'failed to create/update network outage template';
        }

        populateNwkOtgTemplate($noTemple, $ssJsonTemplate);

        // save template
        $noTemple->save();

        return "success";
    }
}
