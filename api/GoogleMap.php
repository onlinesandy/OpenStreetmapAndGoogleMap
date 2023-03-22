<?php
class GoogleMap{
    public $api_url = 'https://maps.googleapis.com/maps/api/geocode/json?';
    private $key = 'YourAPIKEY';
 
   
    public function getLatLong($address){
        $address = str_replace(' ', '+', $address);
        // geocoding api url
        
        $url = $this->api_url ."address=$address";
        if($this->key !=''){            
            $url .= "&key=$this->key";
        }
        // send api request
        $geocode = file_get_contents($url);
        $json = json_decode($geocode);
        print_r($geocode);
        $data['lat'] = $json->results[0]->geometry->location->lat;
        $data['lng'] = $json->results[0]->geometry->location->lng;
        return $data;
    }
}