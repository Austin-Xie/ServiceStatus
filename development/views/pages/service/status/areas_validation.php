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

    if ($goOn) {
        echo "Illegal IP address";
        // return;
    }

    $result = "<!DOCTYPE html><html><head><title>PCodeSuburb</title></head><body><p>"
           . $_GET["suburbs"] . "</p></body></html>";
    echo $result;

?>


