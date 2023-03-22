<?php

include_once "GoogleMap.php";
include_once "OpenStreetMap.php";

class MapFactory {

    public static function getMap($servicetype) {

            switch($servicetype) {
                    case "GoogleMap":
                            $obj = new GoogleMap();
                            break;
                    case "OpenStreetMap":
                            $obj = new OpenStreetMap();
                            break;
                    default:
                            $obj = new GoogleMap();
                            break;
            }

            return $obj;
    }

}
?>
