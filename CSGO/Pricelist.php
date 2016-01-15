<?php

namespace waylaidwanderer\Steamlytics\CSGO;


class Pricelist
{
    private $pricesItems;

    public function __construct($json)
    {
        $this->pricesItems = [];
        foreach ($json['items'] as $marketHashName => $pricesItemJson) {
            if ($pricesItemJson['volume'] > 0) {
                $this->pricesItems[$marketHashName] = new PricesItem($marketHashName, $pricesItemJson);
            }
        }
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