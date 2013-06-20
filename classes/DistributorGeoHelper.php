<?php
namespace Contao;



class DistributorGeoHelper extends Backend
{
    
    
    static $instance;
    public static function getInstance() {
        if (!DistributorGeoHelper::$instance) {
            DistributorGeoHelper::$instance= new DistributorGeoHelper();
                 
        }
        
        return DistributorGeoHelper::$instance;      
        
    }
    
    public function __construct(){
        $this->import("Database");
        
        
    }

    public function findByPlz($plz, $radius, $country="Deutschland", &$ownCoords = null) {
        
        
        
       $ownCoords = $this->plzToCoords($plz, $country);
       
       if (!isset($ownCoords['lat']))
       {
           return false;
       }
       $lat = $ownCoords['lat'];
       $long = $ownCoords['lng'];
       
       /*
         $sql = "     SELECT * 
        ( 3959 * acos( cos( radians(?) ) * cos( radians( lat ) ) * 
        cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * 
        sin( radians( lat ) ) ) ) AS distance 
        FROM tl_DistributorGeoHelper 
        HAVING distance < '%s' 
        ORDER BY distance DESC LIMIT 0 , 18";
        
                // lat, long, lat,long,lat, distance
        $sql = "SELECT *, ACOS(COS(RADIANS(lat)) *
        COS(RADIANS(lng)) * COS(RADIANS(?)) * COS(RADIANS(?)) +
        COS(RADIANS(lat)) * SIN(RADIANS(lng)) * COS(RADIANS(?)) * 
        SIN(RADIANS(?)) + SIN(RADIANS(lat)) * SIN(RADIANS(?))) *"
        // 3963.1 AS Distance
        ." 6430 AS Distance
       SELECT id,  
FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 20;
        * 
        ";*/
    /*$sql = " SELECT *, 6367.41*SQRT(2*
        (1-cos(RADIANS(lat))    
         *cos(".$lat.")*(sin(RADIANS(lng))    
         *sin(".$long.")+cos(RADIANS(lng))    
         *cos(".$long."))-sin(RADIANS(lat))    
         *sin(".$lat."))) as Distance";
      */
    /*$sql = 'SELECT *, ( 3959 * 
                        acos( cos( radians('.$lat.') ) * 
                        cos( radians( lat ) ) * 
                        cos( radians( lng ) - 
                        radians(-'.$long.') ) + 
                        sin( radians('.$lat.') ) * 
                        sin( radians( lat ) ) ) ) AS Distance';
     * 
     * 
      */
      
      // pi / 180 =  0.01745329251
      // / 2 = 0.00872664625
      $sql = ' SELECT *, 3956 * 2 * 2 * ASIN(SQRT(
         POWER(SIN(('.$lat.' - abs(lat)) * 0.00872664625),2) + COS('.$lat.'* 0.01745329251 ) * COS(abs(lat) *  0.01745329251) 
         * POWER(SIN(('.$long .' - lng) *  0.00872664625), 2) )) as Distance';
                           
         
    $sql .= ' 
        FROM tl_DistributorGeoHelper 
        WHERE 1
        ORDER BY distance ASC';
        
        //HAVING Distance <> ? 
        //"; 

          $objGeo = $this->Database->prepare($sql)
                               ->limit(10)
                              // ->execute($lat,$long,$lat,$long, $lat,$radius);
                              ->execute();
                              
         return $objGeo->fetchAllAssoc();
         /*while ($row = $objGeo->next()){
             $results[] = $row;
         }*/
         
        
    }
/**
     * Get geo coordinates from address, thanks to Oliver Hoff <oliver@hofff.com>
     * @param array
     * @return string
     */
     public function plzToCoords ($plz, $country) {
         return $this->geocode($plz.','.$country, false, $strLang = 'de', $country);         
     }
    private $arrGeocodeCache = array();
    public function geocode($varAddress, $blnReturnAll = false, $strLang = 'en', $strRegion = null, array $arrBounds = null) {
        
        // adress, 
        if(is_array($varAddress))
            $varAddress = implode(' ', $varAddress);
        
        $varAddress = trim($varAddress);
        
        if(!strlen($varAddress) || !strlen($strLang))
            return;
        
        if($strRegion !== null && !strlen($strRegion))
            return;
            
        if($arrBounds !== null) {
            if(!is_array($arrBounds) || !is_array($arrBounds['tl']) || !is_array($arrBounds['br'])
            || !is_numeric($arrBounds['tl']['lat']) || !is_numeric($arrBounds['tl']['lng'])
            || !is_numeric($arrBounds['br']['lat']) || !is_numeric($arrBounds['br']['lng']))
                return;
        }
        
        $strURL = sprintf(
            'http://maps.google.com/maps/api/geocode/json?address=%s&sensor=false&language=%s&region=%s&bounds=%s',
            urlencode($varAddress),
            urlencode($strLang),
            strlen($strRegion) ? urlencode($strRegion) : '',
            $arrBounds ? implode(',', $arrBounds['tl']) . '|' . implode(',', $arrBounds['br']) : ''
        );
        
        if(!isset($this->arrGeocodeCache[$strURL])) {
            $arrGeo = json_decode(file_get_contents($strURL), true);
            $this->arrGeocodeCache[$strURL] = $arrGeo['status'] == 'OK' ? $arrGeo['results'] : false;
        }
        
        if(!$this->arrGeocodeCache[$strURL])
            return;
        
        return $blnReturnAll ? $this->arrGeocodeCache[$strURL] : array(
            'lat' => $this->arrGeocodeCache[$strURL][0]['geometry']['location']['lat'],
            'lng' => $this->arrGeocodeCache[$strURL][0]['geometry']['location']['lng']
        );
        
        
    }


    public function curlGeocode() {
        
        throw new Exception("not implemented");
        
            $strGeoURL = 'http://maps.google.com/maps/api/geocode/xml?address='.str_replace(' ', '+', $ogeocoderAddress).'&sensor=false'.($objGeoeocoderCountry ? '&region='.$country : '');

                    $curl = curl_init();
                    if($curl)
                    {
                        if(curl_setopt($curl, CURLOPT_URL, $strGeoURL) && curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1) && curl_setopt($curl, CURLOPT_HEADER, 0))
                        {
                            $curlVal = curl_exec($curl);
                            curl_close($curl);
                            $xml = new SimpleXMLElement($curlVal);
                            if($xml)
                            {
                                // $varValue = $xml->result->geometry->location->lat . ',' . $xml->result->geometry->location->lng;
                            }
                            }
                        $objGeo = $this->Database->prepare($sql)
                                   ->limit(1)
                                   ->execute($xml->result->geometry->location->lat, 
                                             $xml->result->geometry->location->lng,
                                             $dc->id);
                                          
                    } else {
                        // $varValue = "Die Erweiterung CURL fehlt!";
                        die("CURL Fehler");
                    }
                    
    }
}
