<?php

namespace waylaidwanderer\Steamlytics\CSGO;


use waylaidwanderer\Steamlytics\SteamlyticsException;

class CSGO
{
    const BASE_API_URL = "http://api.csgo.steamlytics.xyz/v1/";
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param null $from
     * @param null $currency
     * @return Pricelist
     * @throws SteamlyticsException
     */
    public function getPricelist($from = null, $currency = null)
    {
        try {
            $url = self::BASE_API_URL . 'pricelist?key=' . $this->apiKey;
            if ($from) {
                $url .= '&from=' . $from;
            }
            if ($currency) {
                $url .= '&currency=' . $currency;
            }
            $json = json_decode(file_get_contents($url), true);
            if (!isset($json['success'])) {
                throw new SteamlyticsException('Failed to retrieve v1/pricelist: could not get a response from the API.');
            }
            if ($json['success'] === false) {
                throw new SteamlyticsException('Failed to retrieve v1/pricelist: ' . $json['message']);
            }
            return new Pricelist($json);
        } catch (\Exception $ex) {
            throw new SteamlyticsException('Failed to retrieve v1/pricelist: ' . $ex->getMessage());
        }
    }

    /**
     * @param $marketHashName
     * @param $source
     * @param $from
     * @param $to
     * @param null $currency
     * @return PricesItem
     * @throws SteamlyticsException
     */
    public function getPrice($marketHashName, $source = null, $from = null, $to = null, $currency = null)
    {
        try {
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
            if ($currency) {
                $url .= '&currency=' . $currency;
            }
            $json = json_decode(file_get_contents($url), true);
            if (!isset($json['success'])) {
                throw new SteamlyticsException("Failed to retrieve v1/prices for {$marketHashName} (source: {$source}, from: {$from}, to: {$to}): could not get a response from the API.");
            }
            if ($json['success'] === false) {
                throw new SteamlyticsException("Failed to retrieve v1/prices for {$marketHashName} (source: {$source}, from: {$from}, to: {$to}): {$json['message']}");
            }
            return new PricesItem($marketHashName, $json);
        } catch (\Exception $ex) {
            throw new SteamlyticsException("Failed to retrieve v1/prices for {$marketHashName} (source: {$source}, from: {$from}, to: {$to}): " . $ex->getMessage());
        }
    }

    /**
     * @return Items
     * @throws SteamlyticsException
     */
    public function getItems()
    {
        try {
            $url = self::BASE_API_URL . 'items?key=' . $this->apiKey;
            $json = json_decode(file_get_contents($url), true);
            if (!isset($json['success'])) {
                throw new SteamlyticsException('Failed to retrieve v1/items: could not get a response from the API.');
            }
            if ($json['success'] === false) {
                throw new SteamlyticsException("Failed to retrieve v1/items: {$json['message']}");
            }
            return new Items($json);
        } catch (\Exception $ex) {
            throw new SteamlyticsException('Failed to retrieve v1/items: ' . $ex->getMessage());
        }
    }
}
