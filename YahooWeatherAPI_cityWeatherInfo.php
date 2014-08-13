<?php
namespace citySpecificWeatherInfo;
/**
 * Contains definition of Yahoo Weather API class namely CityWeatherInfo
 * 
 * This file contains one class implementation
 * named CityWeatherInfo class.
 *
 * @category Training/Learning PHP
 * @package Yahoo_Weather_API
 * @version v 1.2
 */

/**
 * Contains city weather info API class
 *
 * This Class uses Yahoo Weather API for getting the city specific
 * RSS Feed and displays weather contents returned by yahoo Weather API.
 * 
 * @package Yahoo_Weather_API
 * @author Muhammad Raza <muhammad.raza@coeus-solutions.de>
 * @category Training/Learning PHP
 * @version v 1.2
 */

class CityWeatherInfo 
{
    public $woeid; //Where on Earth ID for City
    public $timezone; //Timezone of City
    public $countryName; //Country Name of City
    public $placeType; //Type of Place
    public $units; //Units of Weather Info
    public $windInfo; //Weather Wind Info
    public $atmosphereInfo; //Weather Atmosphere Info
    public $astronomyInfo; //Weather Astronomy Info
    public $location; //Location Info
    public $currentWeatherCondition; //Current Weather Condition
    public $weatherForecast; //Weather Forecast
    public $city; //City name returned from API
    private $woeidUrl="http://query.yahooapis.com/v1/public/yql"; //Where on Earth ID URL
    /**
     *
     * Gets the city name from the calling function and return the complete woeid url
     *  
     * 
     * This method/funciton gets city name as a parameter and concatinates 
     * it with url to make complete WOEID URL.  
     * 
     * @param string $cityName 'The city Name to get WOEID URL.'
     * 
     * @return completeWoeidUrl 'Complete URL with CityName'
     */
    
    public function getWoeidUrl($cityName)
    {
        $completeWoeidUrl = $this->woeidUrl."?q=select%20*%20from%20geo.places%"
                . "20where%20text%3D%22$cityName%22&format=xml";
        return $completeWoeidUrl;
    }
    /**
     *
     * Gets the url from the calling function and returns the API response
     * 
     * This method/funciton gets city name as a parameter and concatinates 
     * it with url to make complete WOEID URL.  
     * 
     * @param string $yql_query_url 'The url to get XML From.'
     * 
     * @return string $xml 'XMl returned from API'
     */
    
    public function getResultFromYQL($yql_query_url) 
    {
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $xml = curl_exec($session);
        curl_close($session);
        if($xml==NULL)
        {
            echo 'Error 3: Wrong City Name, No Data Returned from API';
            exit(3);
        }
        return $xml;
    }
    /**
     *
     * Gets the WOEID,Timezone,CityName and Type of Place from Yahoo Weather API
     *
     * This method/funciton gets city name as a parameter and makes an API call 
     * to Yahoo Weather API. The Yahoo Weather API returns in XML format. Using
     * the XML feed returned from Yahoo API this function gets Timezone, 
     * Country name, WOEID(Where On Earth ID) and type of place. 
     * 
     * @param string $cityName the city Name to get WOEID.
     */
    
    public function cityNametoWOEID($cityName)
    {
        $url = $this->getWoeidUrl($cityName);
        $this->cityToWoeidResult = $this->getResultFromYQL($url);
        $xml = simplexml_load_string($this->cityToWoeidResult);
        $this->woeid = $xml->results->place->woeid;
        $this->timezone = $xml->results->place->timezone;
        $this->countryName = $xml->results->place->country;
        $this->placeType = $xml->results->place->placeTypeName;
        $this->city=$xml->results->place->name;
    }
    /**
     *
     * Gets weather feed in XML format from Yahoo Weather API
     *
     * This method uses the class attribute 'WOEID' and makes an API call to 
     * Yahoo Weather API and gets the weather feed in XML format. After
     * getting the RSS feed this function parses the XML feed and gets the
     * weather related info provided by the API and forecast of weather
     * upto 5 days.
     * 
     */
    
    public function getCityWeatherFeed() 
    {
        $url = "http://weather.yahooapis.com/forecastrss?w=$this->woeid&u=c"; 
        $fetchWeatherData = $this->getResultFromYQL($url);
        $xmlWeatherData = simplexml_load_string($fetchWeatherData);
        $this->location = $xmlWeatherData->channel->xpath('yweather:location');

        if (!empty($this->location)) {
            //$this->unit = $xmlWeatherData->channel->xpath('yweather:units');
            $this->unit = $xmlWeatherData->channel->xpath('yweather:units');
            $this->wind = $xmlWeatherData->channel->xpath('yweather:wind');
            $this->atmosphereInfo = 
                    $xmlWeatherData->channel->xpath('yweather:atmosphere');
            $this->astronomyInfo = 
                    $xmlWeatherData->channel->xpath('yweather:astronomy');

            foreach ($xmlWeatherData->channel->item as $data) {
                $this->currentWeatherCondition =
                        $data->xpath('yweather:condition');
                $this->weatherForecast = $data->xpath('yweather:forecast');
                $this->currentWeatherCondition =
                        $this->currentWeatherCondition[0];
            }
        } else {
            echo "Please try a different City.";
            exit(2);
        }
    }
    /**
     *
     * Displays weather Info
     *
     * This method displays the weather Info Set by other two functions/methods
     * of the feed this function parses the XML feed and gets the weather
     * related info provided by the API and forecast of weather upto 5 days.
     * 
     */
    
    public function displayWeatherInfo() 
    {
        printf("\nLocation Info:\n");
        $mask = "|%+13s |%-20s |\n";
        printf($mask, "Country==>", $this->countryName);
        printf($mask, "Time Zone==>", $this->timezone);
        printf($mask, 'Place Type==>', $this->placeType);
        printf("\n");

        printf("Astronomy Info:\n");
        printf($mask, "Sunrise==>", $this->astronomyInfo[0]['sunrise']);
        printf($mask, "Sunset==>", $this->astronomyInfo[0]['sunset']);
        printf("\n");

        $mask2 = "|%+30s |%30s |\n";
        printf("Current Weather Info:\n");
        printf($mask2, "Weather Recorded Time/Date==>", 
               $this->currentWeatherCondition['date']);
        printf($mask2, "Current Temperature==>",
               $this->currentWeatherCondition['temp'] . ' ' .
                $this->unit[0]['temperature']);
        printf($mask2, "Weather Type==>", 
               $this->currentWeatherCondition['text']);
        printf("\n");
        
        printf("Wind Info:\n");
        printf($mask, "Chill==>", 
               $this->wind[0]['chill']);
        printf($mask, "Direction==>", 
               $this->wind[0]['direction']);
        printf($mask, "Speed==>", 
               $this->wind[0]['speed'] . ' ' . $this->unit[0]['speed']);
        printf("\n");
        
        printf("Atmosphere Info:\n");
        printf($mask, "Humidity==>", 
               $this->atmosphereInfo[0]['humidity']);
        printf($mask, "Visibility==>", 
               $this->atmosphereInfo[0]['visibility']);
        printf($mask, "Pressure==>", 
               $this->atmosphereInfo[0]['pressure'] . ' ' . $this->unit[0]['pressure']);
        printf("\n");
         
        $mask3 = "|%5s |%+12s|%5s |%5s |%18s|\n";
        printf("Weather Forecast:\n");
        printf($mask3, "Day", "Date", "Low", "High", "Weather Type");
        for($i=0; $i<5; $i++){
               printf($mask3, $this->weatherForecast[$i]['day'], 
               $this->weatherForecast[$i]['date'], 
               $this->weatherForecast[$i]['low'], 
               $this->weatherForecast[$i]['high'], 
               $this->weatherForecast[$i]['text']);
        }
        printf("\n");
    }
    /**
     *
     * Displays weather Info of a Specific Day
     *
     * This method displays the weather Info Set by other two functions/methods
     * of the feed this function parses the XML feed and gets the weather
     * related info provided by the API and forecast of weather upto 5 days.
     * 
     * @param integer $indexArray 'the index to get Specific Day Weather Info.'
     */
    
    public function displaySpecificDayWeatherInfo($indexArray)
    {
        $mask3 = "|%5s |%+12s|%5s |%5s |%18s|\n";
        printf($mask3, "Day", "Date", "Low", "High", "Weather Type");
        for($i = 0; $i < count($indexArray); $i++)
        {
               $index = $indexArray[$i];
               printf($mask3, $this->weatherForecast[$index]['day'], 
               $this->weatherForecast[$index]['date'], 
               $this->weatherForecast[$index]['low'], 
               $this->weatherForecast[$index]['high'], 
               $this->weatherForecast[$index]['text']);
        }
    }
    /**
     *
     * Returns the unit of Temperature
     *
     * This method the class attribute $unit and return the 
     * unit of temperature from it.
     * 
     * @return string $tempUnit 'Unit of Temperature'
     */
    public function getTemperatureUnit()
    {
        $tempUnit = $this->unit[0]['temperature'];
        return $tempUnit;
    }
}