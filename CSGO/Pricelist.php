<?php

namespace waylaidwanderer\Steamlytics\CSGO;


class Pricelist
{
    private $json;
    private $pricesItems;
    private $fromTimestamp;
    private $buildTime;
    private $updatedAtTimestamp;

    public function __construct($json)
    {
        $this->json = $json;
        $this->pricesItems = [];
        foreach ($json['items'] as $marketHashName => $pricesItemJson) {
            if ($pricesItemJson['volume'] > 0) {
                $this->pricesItems[$marketHashName] = new PricesItem($marketHashName, $pricesItemJson);
            }
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
     * @return PricesItem|null
     */
    public function getPrice($marketHashName) {
        if (isset($this->pricesItems[$marketHashName])) {
            return $this->pricesItems[$marketHashName];
        }
        return null;
    }

    /**
     * @param $marketHashName
     * @return bool
     */
    public function doesItemExist($marketHashName) {
        return isset($this->pricesItems[$marketHashName]);
    }

    /**
     * @return PricesItem[]
     */
    public function getPrices()
    {
        return $this->pricesItems;
    }
}
