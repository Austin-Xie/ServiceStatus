<?php

class ajaxServiceStatus extends ControllerBase
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
    function ajaxQueryServiceStatuses()
    {
        $suburb = $_POST["serviceStatusSuburb"];
		if (is_null($suburb)) {
		    $suburb = "";
		}

		// only 'Online' accessible.
        $status = 3;
        $nos = $this->NetworkOutage_model->getBySuburb($suburb, $status);
		$planned = array();
        $unexpected = array();
        while($no = $nos->next())
        {
		    //echo json_encode($no);
            $expNO = $this->exportNetworkOutageBrief($no);
            if ($expNO['type'] === "Planned") {
                $planned[] = $expNO;
            } else {
			     $expNO['type'] = "Unplanned";
                $unexpected[] = $expNO;
            }
        }

        $networkOutages = array();
        $networkOutages["Planned"] = $planned;
        $networkOutages["Unexpected"] = $unexpected;

        $jsonResp = json_encode($networkOutages);
        if (is_null($_GET['callback'])) {
            echo $jsonResp;
        } else {
            echo $_GET['callback']. '('. $jsonResp .');';
        }
    }
	
	/**
     * This function can be called by sending
     * a request to /ci/ajaxNetworkOutage/ajaxQueryServiceStatusDetails.
     */
	function ajaxQueryServiceStatusDetails()
    {
		$serviceId = $_POST["serviceStatusId"];

        if (!empty($serviceId)) {
            $no = $this->NetworkOutage_model->getNetworkOutageById($serviceId);
            //header('Content-Type: text/javascript');
            $expNO = $this->exportNetworkOutageDetail($no->next());

            $exptNOResp = json_encode($expNO);
            if (is_null($_GET['callback'])) {
                echo $exptNOResp;
            } else {
                echo $_GET['callback']. '('. $exptNOResp .');';
            }
        } else {
		    // return empty object
            echo "{}";
        }
    }

    function exportNetworkOutageBrief($no) {
	    $NOType = array("1" => "Unplanned", "2" => "Planned");
	    $NOState = array("1" => "ACT", "2" => "NSW", "3" => "VIC", "4" => "QLD",
		                 "5" => "SA", "6" => "WA", "7" => "TAS", "8" => "NT");
	    $NOFixStatus = array("1" => "Fixing", "2" => "Fixed");

        $exptNO = array();

        $exptNO['id'] = $no['ID'];
        $exptNO['serviceId'] = $no['OptusNetworkRef'];
        
        $exptNO['state'] = $NOState[$no['State']];
        $exptNO['location'] = $no['Areas'];
        
        $exptNO['serviceAffected'] = $no['CustomService'];
        $exptNO['outageType'] = $no['CustomSummary'];

        $exptNO['type'] = $NOType[$no['Type']];
       
        $exptNO['startTime'] = $no['StartTime'];
        $exptNO['endTime'] = $no['EndTime'];
        
		$exptNO['fixingStatus'] = $NOFixStatus[$no['FixingStatus']];
        

        return $exptNO;
    }

    function exportNetworkOutageDetail($no) {
        $exptNO2 = $this->exportNetworkOutageBrief($no);
        
        $exptNO = array();
        foreach($exptNO2 as $key => $value) {
            $exptNO[$key] = $value;
        }

        $exptNO['updatedTime'] = date('l jS \of F Y h:i:s A', $no['UpdatedTime']);

        $exptNO['description'] = $no['CustomDescription'];
        //$exptNO['technicalSummary'] = $no->TechnicalSummary;
        $exptNO['resolution'] = $no['Resolution'];

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