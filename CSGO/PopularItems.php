<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2016-03-03
 * Time: 2:02 AM
 */

namespace waylaidwanderer\Steamlytics\CSGO;


class PopularItems implements \JsonSerializable
{
    private $json;
    private $items;
    private $buildTime;
    private $updatedAt;

    public function __construct($json)
    {
        $this->json = $json;
        $this->items = [];
        foreach ($json['items'] as $item) {
            $this->items[] = new PopularItem($item);
        }
        $this->buildTime = (int)$json['build_time'];
        $this->updatedAt = (int)$json['updated_at'];
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
     * @return PopularItem[]
     */
    public function getItems()
    {
        return $this->items;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
