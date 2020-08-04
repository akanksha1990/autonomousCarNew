<?php
    
    class CarTravel {

    public $roadtype;
    public $roadLength;

    public function __Construct($obj){
        $this->roadtype=$obj[0];
        $this->roadLength=$obj[1];
        

    }
    public function main_function() {
       
        $car = new Car(70, 200, 0, 0, $this->roadtype); 
        //echo '<pre>';print_r($car); die;
        if($this->roadtype=='urban') {
            $this->travelToUrbanArea($car);
            $this->roadLength-=40;
            $this->mapRoads($car, $this->roadLength);
            if($car->fuel >= 20) {
                $car->journey += 20;
            } else {
                 $this->refuel($car);
                $car->journey += 20;
            }
           $car->fuel -= 20;
           $car->time += 20/($car->speed);
        } else {
            $this->travelToRuralArea($car);
            $this->roadLength-=50;
            $this->mapRoads($car, $this->roadLength);
            if($car->fuel >= 50) {
                $car->journey += 50;
            } else {
                $this->refuel(car);
                $car->journey += 50;
            }
            $car->fuel -= 50;
            $car->time += 50/$car->speed;
        }
        return $car->my_result($car);
    }

    public function mapRoads($car,$roadLength) {
        $oneRunDistance;
         if($car->roadType=='urban'){
            $oneRunDistance = 140;
            $car->time += 130/$car->speed;
            $roadLength = $roadLength - 130;
            $car->journey += 130;
        } else {
            $oneRunDistance = 190;
            $car->time += 145/$car->speed;
            $roadLength = $roadLength - 145;
            $car->journey += 145;
        }
        $this->refuel($car);
        while($roadLength > 0) {
            if($roadLength < $oneRunDistance) {
                $car->fuel -= $roadLength;
                $car->journey += $roadLength;
                $roadLength -= $roadLength;
                $car->time += $roadLength/$car->speed; 
            } else {
                $roadLength -= $oneRunDistance;
                $car->journey += $oneRunDistance;
                $car->fuel -= $oneRunDistance;
                $car->time += $oneRunDistance/$car->speed;
                $this->refuel($car);
            }
        }
    }

    public static function refuel($car) {
        $car->time += 0.5;
        $car->refuelCount++;
        $car->journey += 10;
        if($car->roadType=='urban'){
           $car->fuel = 140;
           $car->time += 10/$car->speed;
        } else {
            $car->fuel = 190;
            $car->time += 10/$car->speed;
        }
        
    }

    /*
        car jurney in urban area is set to 20
        and range reducing by 25% 
        speed limit here also drops by 25%
    */

    public static function travelToUrbanArea($car) {
        $car->journey = 20;
        $car->time = $car->journey/$car->speed;
        $car->fuel = ($car->fuel-20)- (.25*$car->fuel);
        $car->speed = $car->speed - (.25*$car->speed);
    }

    /*
        car jurney in rural area is set to 50
        and range reducing by 15% 
        speed limit here also drops by 15%
    */


    public static function travelToRuralArea($car) {
        $car->journey = 50;
        $car->time = $car->journey/$car->speed;
        $car->fuel = $car->fuel-50;
        $car->speed = $car->speed + (.15*$car->speed);
    }
}

class Car {
    public $speed;
    public $fuel;
    public $journey;
    public $time;
    public $refuelCount;
    public $roadType;

    public function Car($speed, $fuel, $journey,$time,$roadType) {
        $this->speed = $speed;
        $this->fuel = $fuel;
        $this->journey = $journey;
        $this->time = $time;
        $this->refuelCount = 0;
        $this->roadType = $roadType;
    }

    public function my_result() {
        return array('speed'=>$this->speed,
                    'fuel'=>$this->fuel,
                    'journey'=>$this->journey,
                    'time'=>$this->time,
                    'refuelCount'=>$this->refuelCount,
                    'roadType'=>$this->roadType);
    }
}

$arg1 = !empty($argv[1])?$argv[1]:'urban';
$arg2 = !empty($argv[2])?$argv[2]:'900';
$response =new CarTravel(array($arg1,$arg2));
$res=$response->main_function();
echo '<pre>';print_r($res); die;
die;
?>
?>