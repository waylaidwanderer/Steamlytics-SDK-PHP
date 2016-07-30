<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2016-06-29
 * Time: 6:27 AM
 */

namespace waylaidwanderer\Steamlytics\CSGO\V2;


use waylaidwanderer\Steamlytics\CSGO\V2\Pricelist\Prices;

class PricelistItem implements \JsonSerializable
{
    private $json;
    private $name;
    private $safePrice;
    private $safeNetPrice;
    private $ongoingPriceManipulation;
    private $totalVolume;
    private $sevenDays;
    private $thirtyDays;
    private $allTime;
    private $firstSeen;

    public function __construct($marketHashName, $json)
    {
        $this->json = $json;
        $this->name = $marketHashName;
        $this->safePrice = (float)$json['safe_price'];
        $this->safeNetPrice = (float)$json['safe_net_price'];
        $this->ongoingPriceManipulation = (bool)$json['ongoing_price_manipulation'];
        $this->totalVolume = (int)$json['total_volume'];
        $this->sevenDays = new Prices($json['7_days']);
        $this->thirtyDays = new Prices($json['30_days']);
        $this->allTime = new Prices($json['all_time']);
        $this->firstSeen = (int)$json['first_seen'];
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getSafePrice()
    {
        return $this->safePrice;
    }

    /**
     * @return float
     */
    public function getSafeNetPrice()
    {
        return $this->safeNetPrice;
    }

    /**
     * @return boolean
     */
    public function isOngoingPriceManipulation()
    {
        return $this->ongoingPriceManipulation;
    }

    /**
     * @return Prices
     */
    public function getSevenDays()
    {
        return $this->sevenDays;
    }

    /**
     * @return Prices
     */
    public function getThirtyDays()
    {
        return $this->thirtyDays;
    }

    /**
     * @return Prices
     */
    public function getAllTime()
    {
        return $this->allTime;
    }

    /**
     * @return int
     */
    public function getFirstSeen()
    {
        return $this->firstSeen;
    }
}

