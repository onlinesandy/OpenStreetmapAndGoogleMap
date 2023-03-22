<?php
class OpenStreetMap
{
    public $api_url = 'http://nominatim.openstreetmap.org/search?format=json&polygon=1&addressdetails=1&';

    public function getLatLong($address)
    {
        $orgAddress = $address;
        $address = str_replace(' ', '+', str_replace('  ', ' ', $address));
        $url = $this->api_url . "q=$address";

        $httpOptions = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: Nominatim-Test',
            ],
        ];

        $streamContext = stream_context_create($httpOptions);
        $geodata = file_get_contents($url, false, $streamContext);
        $json = json_decode($geodata);
        if(count($json)){
            $data['lat'] = $json[0]->lat;
            $data['lng'] = $json[0]->lon;
            $data['success'] = 1;
        }else{
            $data['error'] = 1;
            $data['message'] = 'No Lat Long Found for this address '.$orgAddress;
        }
        return $data;
    }
}
