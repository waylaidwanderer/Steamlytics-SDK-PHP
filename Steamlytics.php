<?php

namespace waylaidwanderer\Steamlytics;


class Steamlytics
{
    private $apiKey;
    private $csgo;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->csgo = new CSGO\CSGO($apiKey);
    }

    /**
     * @return CSGO\CSGO
     */
    public function getCsgo()
    {
        return $this->csgo;
    }
}