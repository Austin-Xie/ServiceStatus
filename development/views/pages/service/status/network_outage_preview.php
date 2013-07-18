<rn:meta title="#rn:msg:SHP_TITLE_HDG#" template="custom_query.php" clickstream="home"/>

<?
    $legalIP = "203.13";
    $validPreviewIPs = array($legalIP);
    $clientIP = "";
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $proxyIps = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
        $clientIP = $proxyIps[0];
    } else {
        $clientIP = $_SERVER['REMOTE_ADDR'];
    }

    $ips = explode(",", $clientIP);
    $ipGrp = $ips[0].$ips[1];
    $goOn = false;
    foreach($validPreviewIPs as $ip) {
        if ($ip == $ipGrp) {
            $goOn = true;
            break;
        }
    }

    if (!$goOn) {
        echo "Illegal IP address";
        // return;
    }

    echo "Illegal IP address";

?>


<div id="rn_PageContent123" class="rn_Home">
    <div id="rn_PageTitle" class="rn_Home">
        <h1>Service Status - Network Outage</h1>
    </div> 
    <form id="network_outage_preview_form" action="">
        <input id="searchParam" type="text" value="Hello there" />
        <input id="submitBtn" type="submit" value="Go" />
    </form>

    <div id="dynamic"></div>

</div>

