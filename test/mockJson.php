<?php 
    $serviceId = $_POST["serviceStatusId"];
    $suburb = $_POST["serviceStatusSuburb"];

    $testJsonData = json_decode('{' .
    '"Unexpected":['.
        '{"id":15,"serviceId":"2233","state":"NSW","location":"Epping","serviceAffected":"roaming","fixingStatus":"Fixed","outageType":"Internet, Phone & Digital Fetch TV services are experiencing service affecting issues","description":"N/A","type":"Planned", "startTime":"Monday 1st of July 2013 02:52:00 PM","endTime":"Saturday 3rd of August 2013 02:52:00 PM"},'.
        '{"id":25,"serviceId":"2244","state":"NSW","location":"Carlingford","serviceAffected":"Cable","fixingStatus":"Fixed","outageType":"Internet, Phone & Digital Fetch TV services are experiencing service affecting issues","description":"N/A","type":"Planned", "startTime":"Monday 1st of July 2013 02:52:00 PM","endTime":"Saturday 3rd of August 2013 02:52:00 PM"}'.
    '],' .
    '"Planned":[' .
        '{"id":10,"serviceId":"1233","state":"NSW","location":"Epping","serviceAffected":"mobile","outageType":"Internet, Phone & Digital Fetch TV services are experiencing service affecting issues","description":"N/A","type":"Planned","startTime":"Monday 1st of July 2013 02:52:00 PM","endTime":"Saturday 3rd of August 2013 02:52:00 PM"},' .
        '{"id":20,"serviceId":"1244","state":"NSW","location":"Carlingford","serviceAffected":"Cable","outageType":"Internet, Phone & Digital Fetch TV services are experiencing service affecting issues","description":"N/A","type":"Planned","startTime":"Monday 1st of July 2013 02:52:00 PM","endTime":"Saturday 3rd of August 2013 02:52:00 PM"}' .
    ']}');

    // echo json_encode($testJsonData->Planned);
    $unexpectedEvents = $testJsonData->Unexpected;
    $plannedEvents  = $testJsonData->Planned;
    //echo json_encode($plannedEvents);

    if (!empty($serviceId)) {
        $serviceId = intval($serviceId);
        foreach ($unexpectedEvents as $ue) {
            if ($ue->id == $serviceId) {
               echo json_encode($ue);
               break;
            }
        }

        $matchPlanned = array();
        foreach ($plannedEvents as $pe) {
            if ($pe->id == $serviceId) {
                echo json_encode($pe);
                break;
            }
        }
        return;
    } else if (!empty($suburb)) {
        $networkOutages = array();

        $matchUnexpected = array();
        foreach ($unexpectedEvents as $ue) {
            if (strcasecmp($ue->location,$suburb) == 0) {
                $matchUnexpected[] = $ue;
            }
        }

        $matchPlanned = array();
        foreach ($plannedEvents as $pe) {
            if (strcasecmp($pe->location,$suburb) == 0) {
                $matchPlanned[] = $pe;
            }
        }
        $networkOutages["Planned"] = $matchPlanned;
        $networkOutages["Unexpected"] = $matchUnexpected;

        echo json_encode($networkOutages);
        return;
    } else { // By default, show all issues.
        echo json_encode($testJsonData);
    }
?>