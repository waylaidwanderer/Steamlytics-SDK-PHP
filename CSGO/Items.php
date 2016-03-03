<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2016-03-03
 * Time: 1:50 AM
 */

namespace waylaidwanderer\Steamlytics\CSGO;


class Items implements \JsonSerializable
{
    private $json;
    private $numItems;
    private $items;

    public function __construct($json)
    {
        $this->json = $json;
        $this->numItems = (int)$json['num_items'];
        $this->items = [];
        foreach ($json['items'] as $item) {
            $this->items[] = new Item($item);
        }
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
    public function getNumItems()
    {
        return $this->numItems;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
