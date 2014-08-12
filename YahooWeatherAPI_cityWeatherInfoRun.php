<?php
namespace citySpecificWeatherInfo;
/**
 * Contains Run function for City weather Info driver Class
 *
 * This file contains one function
 * that acts as a Driver for CityWeatherInfo.
 *
 * @category Training/Learning PHP
 * @package Yahoo_Weather_API
 * @version v 1.2
 */
require_once  ('YahooWeatherAPI_cityWeatherInfo.php');
require_once  ('YahooWeatherAPI_cityWeatherStatisticsCalculator.php');
require_once  ('YahooWeatherAPI_cityWeatherInfoDriver.php');
     /**
     *
     * Calling Driver class run function
     *
     */
        $city="";
        if (count($argv) < 2) {
            echo "Error 3: City Name Not Entered" . PHP_EOL;
            exit(3);
        }
        else {
            if(count($argv)==2) {
                $city = $argv[1];
            }
            else {
                for($i=1; $i<count($argv); $i++){
                    $city = $city . ' ' . $argv[$i];
                }
            }
        $driverObj = new CityWeatherInfoDriver();
        $driverObj->runCityWeatherInfo($city);
        }