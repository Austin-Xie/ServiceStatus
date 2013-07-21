<?php

class ajaxNetworkOutage extends ControllerBase
{
    //This is the constructor for the custom controller. Do not modify anything within
    //this function.
    function __construct()
    {
        parent::__construct();

        $this->load->model('custom/ServiceStatus/NetworkOutage_model');
    }
	
	function ajaxQueryTest() {
		//echo '{"ajax": "OK!"}';
		 echo '{"msg": "FFFFFFFFFFFFFFFKKKKKKKKKKKKKKKKKK"}';
	}
    
    
    /**
     * This function can be called by sending
     * a request to /ci/ajaxNetworkOutage/ajaxQueryNetworkOutages.
     */
    function ajaxQueryNetworkOutages()
    {
		$serviceId = $_POST["serviceStatusId"];
        $suburb = $_POST["serviceStatusSuburb"];

        if (!empty($serviceId)) {
            //$svcStsId = $_GET['serviceStatusId'];

            $no = $this->NetworkOutage_model->getNetworkOutageById($svcStsId);
            //header('Content-Type: text/javascript');
            $expNO = $this->exportNetworkOutageDetail($no->next());

            $exptNOResp = json_encode($expNO);
            if (is_null($_GET['callback'])) {
                echo $exptNOResp;
            } else {
                echo $_GET['callback']. '('. $exptNOResp .');';
            }
        } else if (!empty($suburb)) {            
            // only 'Online' accessible.
            $status = 'Online'; //"('Online')"; //"('Edit', 'Review', 'Online')";

            $nos = $this->NetworkOutage_model->getBySuburb($suburb, $status);

            $planned = array();
            $unexpected = array();
            while($no = $nos->next())
            {
                $expNO = $this->exportNetworkOutageBrief($no);

                if ($expNO['type'] === 'Planned') {
                    $planned[] = $expNO;
                } else {
                    $unexpected[] = $expNO;
                }
            }
    
            $networkOutages = array();
            $networkOutages["Planned"] = $planned;
            $networkOutages["Unexpected"] = $unexpected;
            
    
            //header('Content-Type: text/javascript');
            $jsonResp = json_encode($networkOutages);
            if (is_null($_GET['callback'])) {
                echo $jsonResp;
            } else {
                echo $_GET['callback']. '('. $jsonResp .');';
            }

        } else {
            echo "{}";
        }

    }

    function exportNetworkOutageBrief($no) {
        $exptNO = array();

        $exptNO['id'] = $no->ID;
        $exptNO['serviceId'] = $no->OptusNetworkRef;
        
        $exptNO['state'] = $no->State->Name;
        $exptNO['location'] = $no->Areas;
        
        $exptNO['serviceAffected'] = $no->CustomCustomService;
        $exptNO['summary'] = $no->CustomSummary;

        $exptNO['type'] = $no->Type->Name;
        if ($exptNO['type'] === "Planned") {
            $exptNO['startTime'] = date('l jS \of F Y h:i:s A', $no->StartTime);
            $exptNO['endTime'] = date('l jS \of F Y h:i:s A', $no->EndTime);
        } else {
            $exptNO['fixingStatus'] = $no->FixingStatus->Name;
        }

        return $exptNO;
    }


    function exportNetworkOutageDetail($no) {
        $exptNO2 = $this->exportNetworkOutageBrief($no);
        
        $exptNO = array();
        foreach($exptNO2 as $key => $value) {
            $exptNO[$key] = $value;
        }

        $exptNO['updatedTime'] = date('l jS \of F Y h:i:s A', $no->UpdatedTime);

        $exptNO['description'] = $no->CustomDescription;

        $exptNO['technicalSummary'] = $no->TechnicalSummary;
        $exptNO['resolution'] = $no->Resolution;

        return $exptNO;
    }

    function getRealClientIP() {
        
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $proxyIps = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            return $proxyIps[0];
        }

        return $_SERVER['REMOTE_ADDR'];
    }

}