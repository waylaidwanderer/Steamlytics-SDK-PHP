<?php

namespace waylaidwanderer\Steamlytics\CSGO;


use waylaidwanderer\Steamlytics\CSGO\V2\PricelistItem;

class Pricelist implements \JsonSerializable
{
    private $json;
    private $pricelistItems;
    private $fromTimestamp;
    private $buildTime;
    private $updatedAtTimestamp;

    public function __construct($json)
    {
        $this->json = $json;
        $this->pricelistItems = [];
        foreach ($json['items'] as $marketHashName => $pricesItemJson) {
            $this->pricelistItems[$marketHashName] = new PricelistItem($marketHashName, $pricesItemJson);
        }
        $this->fromTimestamp = $json['from'];
        $this->buildTime = $json['build_time'];
        $this->updatedAtTimestamp = $json['updated_at'];
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
     * @return int
     */
    public function getFromTimestamp()
    {
        return $this->fromTimestamp;
    }

    /**
     * @return int
     */
    public function getBuildTime()
    {
        return $this->buildTime;
    }

    /**
     * @return int
     */
    public function getUpdatedAtTimestamp()
    {
        return $this->updatedAtTimestamp;
    }

    /**
     * @param $marketHashName
     * @return PricelistItem|null
     */
    public function getPrice($marketHashName) {
        if (isset($this->pricelistItems[$marketHashName])) {
            return $this->pricelistItems[$marketHashName];
        }
        return null;
    }

    /**
     * @param $marketHashName
     * @return bool
     */
    public function doesItemExist($marketHashName) {
        return isset($this->pricelistItems[$marketHashName]);
    }

    /**
     * @return PricelistItem[]
     */
    public function getPrices()
    {
        return $this->pricelistItems;
    }
}
