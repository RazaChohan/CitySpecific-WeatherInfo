<?php
namespace citySpecificWeatherInfo;
/**
 * Contains definition of Yahoo Weather API Statistics Calculator class
 *
 * This file contains one class implementation
 * named CityWeatherStatisticsCalculator class.
 *
 * @category Training/Learning PHP
 * @package Yahoo_Weather_API
 * @version v 1.2
 */

/**
 * Contains City Weather Statistics Calculator class Implementation
 *
 * This Class calculates different statistics of weather by getting
 * weather forcast of five days.
 * 
 * @package Yahoo_Weather_API
 * @author Muhammad Raza <muhammad.raza@coeus-solutions.de>
 * @category Training/Learning PHP
 * @version v 1.2
 */

class CityWeatherStatisticsCalculator 
{
    /**
     *
     * Calculates the average temp from two values of temperature
     *
     * This method gets two values from the callee both are the temperature 
     * readings and calculates the average of both temperatures and returns 
     * the calculated average temperature.
     * 
     * @param integer low 'Lowest Temperature of the day'
     *        integer high 'Highest Temperature of the day'
     * 
     * @return integer avg 'Average Calculated Temperature'
     */
    
    public function calculateAverageTemp($low, $high) 
    {
        $sum = intval($low) + intval($high);
        $avg = $sum / 2;
        return floatval($avg);
    }
    /**
     *
     * Assesses the warmest day/days using the weather forecast
     *
     * This method/funciton gets weather forecast in an array from the callee 
     * and on the basis of average temperature calculated returns the array 
     * containing index of day/days which is/are warmest among all.  
     *  
     * @param array $weatherForecast 'Weather Forecast of Five days'
     * 
     * @return array $$returnIndexValues 'Array of Indexes
     * 
     */
    
    public function assessWarmestDay($weatherForecast) 
    {
        $returnIndexValues = array();
        $index = 0;
        $maxAvg = $this->calculateAverageTemp($weatherForecast[0]['high'],
                $weatherForecast[0]['low']);
        array_push($returnIndexValues,$index);
        for ($x = 1; $x <= 4; $x++) {
            $currentAvg=$this->calculateAverageTemp($weatherForecast[$x]['high'],
                $weatherForecast[$x]['low']);
            if (floatval($maxAvg) < floatval($currentAvg)) {
                unset($returnIndexValues);
                $returnIndexValues = array();
                $maxAvg = $currentAvg;
                $index = $x;
                array_push($returnIndexValues,$index);
            } elseif (floatval($maxAvg) == floatval($currentAvg)) {
                $index = $x;
                array_push($returnIndexValues,$index);
            }
        }
        return $returnIndexValues;
    }
    /**
     *
     * Assesses the coolest day/days using the weather forecast
     *
     * This method/funciton gets weather forecast in an array from the callee 
     * and on the basis of average temperature calculated returns the array 
     * containing index of day/days which is/are coolest among all.  
     *  
     * @param array  $weatherForecast 'Weather Forecast of Five days'
     * 
     * @return array $returnIndexValues 'Array of Indexes
     * 
     */
    
    public function assessCoolestDay($weatherForecast) 
    {
        $returnIndexValues = array();
        $index = 0;
        $minAvg = $this->calculateAverageTemp($weatherForecast[0]['high'],
                $weatherForecast[0]['low']);
        array_push($returnIndexValues,$index);
        for ($x = 1; $x <= 4; $x++) {
            $currentAvg = $this->calculateAverageTemp($weatherForecast[$x]['high'],
                $weatherForecast[$x]['low']);
            if (floatval($minAvg) > floatval($currentAvg)) {
                unset($returnIndexValues);
                $returnIndexValues = array();
                $minAvg = $currentAvg;
                $index = $x;
                array_push($returnIndexValues,$index);
            } elseif (floatval($minAvg) == floatval($currentAvg)) {
                $index = $x;
                array_push($returnIndexValues,$index);
            }
        }
        return $returnIndexValues;
    }
    /**
     *
     * Calculates the average High Temperature from High Temperature of five days.
     *
     * Gets weather forecast array from the callee and calculates the 
     * average high temperature from the weather data of five days.
     *
     * @param array  $weatherForecast Weather Forecast of five days
     *        string $unit            Unit of Temperature returned from Yahoo Weather API
     */
    
    public function averageHighTemp($weatherForecast, $unit) 
    {
        $arrayHighTemps = array();
        for($i = 0; $i < 5; $i++) {
            array_push($arrayHighTemps,intval($weatherForecast[$i]['high']));   
        }
        echo "\n";
        echo "Average High Temperature:" . ' ' . (array_sum($arrayHighTemps)/5)
                                         . ' ' . $unit . PHP_EOL;    
    }
     /**
     *
     * Calculates the average low Temperature from low Temperature of five days.
     *
     * Gets weather forecast array from the callee and calculates the 
     * average low temperature from the weather data of five days.
     *
     * @param array  $weatherForecast Weather Forecast of five days
     *        string $unit            Unit of Temperature returned from Yahoo Weather API
     */ 
    
    public function averageLowTemp($weatherForecast, $unit) 
    {
        $arrayLowTemps = array();
        for($i = 0; $i < 5; $i++) {
            array_push($arrayLowTemps,intval($weatherForecast[$i]['low']));
        }
        echo "Average Low Temperature:" . ' ' . (array_sum($arrayLowTemps)/5)
                                        . ' ' . $unit . PHP_EOL;
    }
    /**
     *
     * Asssess the frequent Weather type from weather forecast
     *
     * This method gets the weather forecast from the callee and assesses 
     * the most frequent weather type in coming five days.
     * 
     * @param array $weatherForecast 'weather forecast of five days'
     * 
     */
    
    public function frequentWeatherType($weatherForecast)
    {
        $weatherType = array();       
        $weatherTypeArray = array();
        $frequency = 0;
        for($i = 0; $i < 5; $i++){
             array_push($weatherType,strval($weatherForecast[$i]['text']));
        }
        $count = intval(0);
        $new_array = array_count_values($weatherType);
        echo "\n";
        while (list ($key, $val) = each ($new_array)) {     
        if(intval($count) == 0) {
        $frequency = $val;
        array_push($weatherTypeArray,$key);
        $count = $count + 1;
        }
        else{
            if($val > $frequency) {   
                unset($weatherTypeArray);
                $weatherTypeArray = array();
                array_push($weatherTypeArray,$key);
                $frequency = $val;
            }
                elseif ($val == $frequency) {
                    array_push($weatherTypeArray,$key);
                }
            }
        }   
        echo "Frequent Weather Types: ".PHP_EOL;
        for($i = 0; $i < count($weatherTypeArray); $i++) {
            echo "==>" . $weatherTypeArray[$i] . PHP_EOL;
        }
    }
}