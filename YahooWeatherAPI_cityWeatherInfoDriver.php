<?php

/**
 * Contain Run/Driver function for City weather Info Class
 * CityWeatherInfoDriver
 *
 * This file  contains one Class
 * that acts as a Driver for CityWeatherInfo class.
 *
 *
 * LICENSE: Licensed Under Coeus Solutions GmBH
 *
 * @category Training/Learning PHP
 * @package Yahoo_Weather_API
 * @copyright Coeus-Solutions GmBH
 * @version v 1.1
 */
require_once ('YahooWeatherAPI_cityWeatherInfo.php');

/**
 * CityWeatherInfoDriver class
 *
 * This Class Implements the functionality of a Driver for 
 * city weatherInfo class in the same package of Yahoo_Weather_API
 * 
 *
 * @package Yahoo_Weather_API
 * @author Muhammad Raza <muhammad.raza@coeus-solutions.de>
 * @category Training/Learning PHP
 * @copyright Coeus-Solutions GmBH
 * @version v 1.1
 */
class cityWeatherInfoDriver {

    /**
     * Interface for Executing functionality of cityWeatherInfo Class
     *
     * This method asks the user to give input on the basis of that it
     * enables to user to interact with class functionality.
     *
     *
     *
     */
    public function cityWeatherInfo_run($cityname) {
        $cityWeatherInfoObj = new CityWeatherInfo();

        $cityWeatherInfoObj->cityNametoWOEID($cityname);
        if ($cityWeatherInfoObj->woeid == "") {
            echo "Error 1: City Name not Found";
            exit(1);
        }
        $cityWeatherInfoObj->getCityWeatherFeed($cityWeatherInfoObj->woeid);
        $cityWeatherInfoObj->displayWeatherInfo();
    }
}

////////////////////////////////////////////////////////////
if (count($argv) < 2) {
    echo "Error 3: City Name Not Entered" . PHP_EOL;
    exit(3);
}
$city = $argv[1];
$DriverObj = new cityWeatherInfoDriver();
$DriverObj->cityWeatherInfo_run($city); //Calling Run Function




