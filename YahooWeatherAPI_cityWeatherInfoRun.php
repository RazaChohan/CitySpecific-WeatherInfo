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

function printHelp()
{
    echo "Usage: php YahooWeatherAPI_cityWeatherInfoRun.php 'cityname' without quotes" . PHP_EOL;
}
     /**
     *
     * Calling Driver class run function
     *
     */
        $city="";
        $temperatureUnit="c";
        
        if (count($argv) < 2) {
            printHelp();
            exit(3);
        }
        else if (strpos($argv[1],'help') !== false) {
            printHelp();
            return;
        }
        else {
            if(count($argv)==2) {
                $city = $argv[1];
                str_replace('"', "", $city);
            }
            else {
                for($i=1; $i<count($argv); $i++){
                    $city = $city . ' ' . $argv[$i];
                }
            }
        $driverObj = new CityWeatherInfoDriver();
        $driverObj->runCityWeatherInfo($city,$temperatureUnit);
        }