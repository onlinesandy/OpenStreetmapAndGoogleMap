<?php
require_once 'MapFactory.php';

if (isset($_REQUEST['getlatlong']) && isset($_REQUEST['address']) && $_REQUEST['address'] != '') {
    $mapType = isset($_REQUEST['mapType']) && $_REQUEST['mapType'] != '' ? $_REQUEST['mapType'] : 'GoogleMap';
    $address = $_REQUEST['address'];
    $geoObj = MapFactory::getMap($mapType);
    $response = $geoObj->getLatLong($address);
    echo json_encode($response);
    die;
}

?>
