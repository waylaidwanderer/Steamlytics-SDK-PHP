<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 2015-12-16
 * Time: 3:56 AM
 */

namespace App\Steamlytics\CSGO;


use App\Steamlytics\SteamlyticsException;

class CSGO
{
    const BASE_API_URL = "http://csgo.steamlytics.xyz/api/v1/";
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return Pricelist
     * @throws SteamlyticsException
     */
    public function getPricelist()
    {
        $url = self::BASE_API_URL . 'pricelist?key=' . $this->apiKey;
        $json = json_decode(file_get_contents($url), true);
        if (isset($json['success']) && $json['success'] === true) {
            return new Pricelist($json);
        }
        throw new SteamlyticsException('Failed to retrieve v1/pricelist.');
    }

    /**
     * @param $marketHashName
     * @param $source
     * @param $from
     * @param $to
     * @return PricesItem
     * @throws SteamlyticsException
     */
    public function getPrice($marketHashName, $source = null, $from = null, $to = null)
    {
        $url = self::BASE_API_URL . 'prices/' . str_replace('%2F', '%252F', rawurlencode($marketHashName)) . '?key=' . $this->apiKey;
        if ($source) {
            $url .= '&source=' . $source;
        }
        if ($from) {
            $url .= '&from=' . $from;
        }
        if ($to) {
            $url .= '&to=' . $to;
        }
        $json = json_decode(file_get_contents($url), true);
        if (isset($json['success']) && $json['success'] === true) {
            return new PricesItem($marketHashName, $json);
        }
        throw new SteamlyticsException("Failed to retrieve v1/prices for {$marketHashName}. Source: {$source}, from: {$from}, to: {$to}.");
    }
}