<?php

namespace waylaidwanderer\Steamlytics\CSGO;


class PricesItem
{
    private $name;
    private $medianPrice;
    private $medianNetPrice;
    private $averagePrice;
    private $averageNetPrice;
    private $lowestPrice;
    private $lowestNetPrice;
    private $highestPrice;
    private $highestNetPrice;
    private $deviation;
    private $deviationPercentage;
    private $volume;
    private $firstSeen;

    public function __construct($marketHashName, $json)
    {
        $this->name = $marketHashName;
        $this->medianPrice = (float)$json['median_price'];
        $this->medianNetPrice = (float)$json['median_net_price'];
        $this->averagePrice = (float)$json['average_price'];
        $this->averageNetPrice = (float)$json['average_net_price'];
        $this->lowestPrice = (float)$json['lowest_price'];
        $this->lowestNetPrice = (float)$json['lowest_net_price'];
        $this->highestPrice = (float)$json['highest_price'];
        $this->highestNetPrice = (float)$json['highest_net_price'];
        $this->deviation = (float)$json['mean_absolute_deviation'];
        $this->deviationPercentage = (float)$json['deviation_percentage'];
        $this->volume = (int)$json['volume'];
        $this->firstSeen = (int)$json['first_seen'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getMedianPrice()
    {
        return $this->medianPrice;
    }

    /**
     * @return float
     */
    public function getMedianNetPrice()
    {
        return $this->medianNetPrice;
    }

    /**
     * @return float
     */
    public function getAveragePrice()
    {
        return $this->averagePrice;
    }

    /**
     * @return float
     */
    public function getAverageNetPrice()
    {
        return $this->averageNetPrice;
    }

    /**
     * @return float
     */
    public function getLowestPrice()
    {
        return $this->lowestPrice;
    }

    /**
     * @return float
     */
    public function getLowestNetPrice()
    {
        return $this->lowestNetPrice;
    }

    /**
     * @return float
     */
    public function getHighestPrice()
    {
        return $this->highestPrice;
    }

    /**
     * @return float
     */
    public function getHighestNetPrice()
    {
        return $this->highestNetPrice;
    }

    /**
     * @return float
     */
    public function getDeviation()
    {
        return $this->deviation;
    }

    /**
     * @return float
     */
    public function getDeviationPercentage()
    {
        return $this->deviationPercentage;
    }

    /**
     * @return int
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @return int
     */
    public function getFirstSeen()
    {
        return $this->firstSeen;
    }
}