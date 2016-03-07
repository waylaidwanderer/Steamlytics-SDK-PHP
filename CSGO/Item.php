<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2016-03-03
 * Time: 1:49 AM
 */

namespace waylaidwanderer\Steamlytics\CSGO;


class Item implements \JsonSerializable
{
    private $json;
    private $marketName;
    private $marketHashName;
    private $iconUrl;
    private $nameColor;
    private $qualityColor;

    public function __construct($json)
    {
        $this->json = $json;
        $this->marketName = $json['market_name'];
        $this->marketHashName = $json['market_hash_name'];
        $this->iconUrl = $json['icon_url'];
        $this->nameColor = $json['name_color'];
        $this->qualityColor = $json['quality_color'];
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
    public function getMarketName()
    {
        return $this->marketName;
    }

    /**
     * @return string
     */
    public function getMarketHashName()
    {
        return $this->marketHashName;
    }

    /**
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
    }

    /**
     * @return string
     */
    public function getNameColor()
    {
        return $this->nameColor;
    }

    /**
     * @return string
     */
    public function getQualityColor()
    {
        return $this->qualityColor;
    }
}
