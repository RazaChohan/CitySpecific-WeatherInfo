<?php
namespace citySpecificWeatherInfo;
/**
 * Contain Run/Driver function for City weather Info Class
 *
 * This file  contains one Class
 * that acts as a Driver for CityWeatherInfo class.
 *
 * @category Training/Learning PHP
 * @package Yahoo_Weather_API
 * @version v 1.2
 */

/**
 * Contains city weather info API driver class
 *
 * This Class Implements the functionality of a Driver for 
 * city weatherInfo class in the same package of Yahoo_Weather_API
 * 
 *
 * @package Yahoo_Weather_API
 * @author Muhammad Raza <muhammad.raza@coeus-solutions.de>
 * @category Training/Learning PHP
 * @version v 1.2
 */

class CityWeatherInfoDriver 
{
    private $cityWeatherInfoObj; //City Weather info Class Object
    private $statisticsCalculatorObj; //Stat
    /**
     * Interface for Executing functionality of cityWeatherInfo Class
     *
     * This method asks the user to give input on the basis of that it
     * enables to user to interact with class functionality.
     *
     * @param string $cityname 'City Name'
     */
    
    public function runCityWeatherInfo($cityname) 
    {
        $this->cityWeatherInfoObj = new CityWeatherInfo();
        $this->cityWeatherInfoObj->cityNametoWOEID($cityname);
        if ($this->cityWeatherInfoObj->woeid == "") {
            echo "Error 1: City Name not Found";
            exit(1);
        }
        $this->cityWeatherInfoObj->getCityWeatherFeed($this->cityWeatherInfoObj->woeid);
        $this->cityWeatherInfoObj->displayWeatherInfo();
        $this->statisticsCalculatorObj = new CityWeatherStatisticsCalculator();
        $warmestDays = $this->statisticsCalculatorObj->assessWarmestDay
                ($this->cityWeatherInfoObj->weatherForecast);
        $coolestDays = $this->statisticsCalculatorObj->assessCoolestDay
                ($this->cityWeatherInfoObj->weatherForecast);

        printf("Warmest Day/Days");
        printf("\n");
        $this->cityWeatherInfoObj->displaySpecificDayWeatherInfo($warmestDays);
        printf("Coolest Day/Days");
        printf("\n");
        $this->cityWeatherInfoObj->displaySpecificDayWeatherInfo($coolestDays);
        $this->statisticsCalculatorObj->averageHighTemp
                ($this->cityWeatherInfoObj->weatherForecast,$this->cityWeatherInfoObj->getTemperatureUnit());
        $this->statisticsCalculatorObj->averageLowTemp
                ($this->cityWeatherInfoObj->weatherForecast,$this->cityWeatherInfoObj->getTemperatureUnit());
        $this->statisticsCalculatorObj->frequentWeatherType
                ($this->cityWeatherInfoObj->weatherForecast);
    }
}
