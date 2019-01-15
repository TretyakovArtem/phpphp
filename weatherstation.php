<?php


interface Subject
{
    public function registerObserver(Observer $o);
    public function removeObserver(Observer $o);
    public function notifyObservers();
}

interface Observer
{
    public function update($temp, $humidity, $pressure);
}

interface DisplayElement
{
    public function display();
}

class WeatherData implements Subject
{
    private $observers = [];
    private $temperature;
    private $humidity;
    private $pressure;


    public function registerObserver(Observer $o)
    {
        $this->observers[] = $o;
    }

    public function removeObserver(Observer $o)
    {
        $index = array_search($o, $this->observers);
        if ($index >= 0) {
            unset($this->observers[$index]);
        }
    }

    public function notifyObservers()
    {
        for($i = 0; $i < count($this->observers); $i++) {
            $observer = $this->observers[$i];
            $observer->update($this->temperature, $this->humidity, $this->pressure);
        }
    }

    public function measurementsChanged()
    {
        $this->notifyObservers();
    }


    public function setMeasurements($temperature, $humidity, $pressure)
    {
        $this->temperature = $temperature;
        $this->humidity    = $humidity;
        $this->pressure    = $pressure;
        $this->measurementsChanged();
    }
}


class CurrentConditionsDisplay implements Observer, DisplayElement
{
    private $temperature;
    private $humidity;
    private $weatherData;

    public function __construct(Subject $weatherData)
    {
        $this->weatherData = $weatherData;
        $weatherData->registerObserver($this);
    }

    public function update($temp, $humidity, $pressure)
    {
        $this->temperature = $temp;
        $this->humidity    = $humidity;
        $this->display();

    }

    public function display()
    {
        echo "Текущее состояние: \n". $this->temperature. "C, \n". $this->humidity;
    }
}


class WeatherStation
{
    public static function main()
    {
        $weatherData = new WeatherData();
        $currentDisplay = new CurrentConditionsDisplay($weatherData);

        $weatherData->setMeasurements(30, 50, 730);
    }
}

WeatherStation::main();