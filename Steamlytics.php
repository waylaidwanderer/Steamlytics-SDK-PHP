<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2015-12-16
 * Time: 3:43 AM
 */

namespace App\Steamlytics;


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