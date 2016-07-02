<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2016-06-29
 * Time: 6:27 AM
 */

namespace waylaidwanderer\Steamlytics\CSGO\V2\Pricelist;


class Prices implements \JsonSerializable
{
    private $json;
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
    private $trend;
    private $volume;

    public function __construct($json)
    {
        $this->json = $json;
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
        $this->trend = (float)$json['trend'];
        $this->volume = (int)$json['volume'];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return $this->json;
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
     * @return float
     */
    public function getTrend()
    {
        return $this->trend;
    }

    /**
     * @return int
     */
    public function getVolume()
    {
        return $this->volume;
    }
}
