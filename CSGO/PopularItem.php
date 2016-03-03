<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2016-03-03
 * Time: 2:03 AM
 */

namespace waylaidwanderer\Steamlytics\CSGO;


class PopularItem implements \JsonSerializable
{
    private $json;
    private $rank;
    private $marketHashName;
    private $volume;

    public function __construct($json)
    {
        $this->json = $json;
        $this->rank = (int)$json['rank'];
        $this->marketHashName = $json['market_hash_name'];
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
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @return string
     */
    public function getMarketHashName()
    {
        return $this->marketHashName;
    }

    /**
     * @return int
     */
    public function getVolume()
    {
        return $this->volume;
    }
}
