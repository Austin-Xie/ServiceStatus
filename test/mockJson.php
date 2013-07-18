<?php 
    $serviceId = $_GET["serviceStatusId"];
    $suburb = $_GET["serviceStatusSuburb"];

    $testJsonData = json_decode('{' .
    '"Unexpected":['.
        '{"id":15,"serviceId":"2233","state":"NSW","location":"Epping","serviceAffected":null,"summary":"Internet, Phone & Digital Fetch TV services are experiencing service affecting issues","type":"Planned"},'.
        '{"id":25,"serviceId":"2244","state":"NSW","location":"Carlingford","serviceAffected":"Cable","summary":"Internet, Phone & Digital Fetch TV services are experiencing service affecting issues","type":"Planned"}'.
    '],' .
    '"Planned":[' .
        '{"id":10,"serviceId":"1233","state":"NSW","location":"Epping","serviceAffected":null,"summary":"Internet, Phone & Digital Fetch TV services are experiencing service affecting issues","type":"Planned","startTime":"Monday 1st of July 2013 02:52:00 PM","endTime":"Saturday 3rd of August 2013 02:52:00 PM"},' .
        '{"id":20,"serviceId":"1244","state":"NSW","location":"Carlingford","serviceAffected":"Cable","summary":"Internet, Phone & Digital Fetch TV services are experiencing service affecting issues","type":"Planned","startTime":"Monday 1st of July 2013 02:52:00 PM","endTime":"Saturday 3rd of August 2013 02:52:00 PM"}' .
    ']}');

    // echo json_encode($testJsonData->Planned);
    $unexpectedEvents = $testJsonData->Unexpected;
    $plannedEvents  = $testJsonData -> Planned;
    //echo json_encode($plannedEvents);

    if (!is_null($serviceId)) {
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

    } else if (!is_null($suburb)) {
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
    } else {
        echo "{}";
    }
?>