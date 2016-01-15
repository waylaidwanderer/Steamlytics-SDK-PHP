# Steamlytics-SDK-PHP
PHP library for Steamlytics' various APIs.

## Installation

You can install the package using Composer with the command:

`composer require waylaidwanderer/steamlytics-sdk-php`

## Todo

* Implement the rest of Steamlytics:CSGO APIs
* Add Steamlytics:Steam APIs

## Example

Here's an adapted example for this SDK, used in a Laravel app.

    // Let's say we have an array of items we want to get prices for, named $marketHashNames
    $pricelist = Helper::getPricelist();
    foreach ($marketHashNames as $marketHashName) {
        $price = Helper::getPrice($marketHashName, $pricelist);
        if ($price == 0) {
            // item price is either inaccurate or not found, ignore it
        }
    }    

The `Helper` class:

    class Helper
    {
        const STEAMLYTICS_API_KEY = "YOUR_API_KEY";
            
        public static function getPricelist()
        {
            if (!Cache::has('pricelist')) {
                return self::cachePricelist();
            }
            return Cache::get('pricelist');
        }
    
        public static function cachePricelist()
        {
            try {
                $steamlyticsCSGO = new CSGO(self::STEAMLYTICS_API_KEY);
                $pricelist = $steamlyticsCSGO->getPricelist();
                Cache::forever('pricelist', $pricelist);
                return $pricelist;
            } catch (\Exception $ex) {
                return NULL;
            }
        }
    
        /**
         * @param int $appId
         * @param string $marketHashName
         * @param Pricelist $pricelist
         * @return float
         */
        public static function getPrice($marketHashName, $pricelist = null) {
            $price = 0;
            if ($pricelist == null) {
                $pricelist = self::getPricelist();
            }
            if ($pricelist->doesItemExist($marketHashName)) {
                $prices = $pricelist->getPrices($marketHashName);
                if ($prices->getVolume() >= 10) {
                    $price = $prices->getMedianPrice();
                } else {
                    // return a price of 0 if volume is too low, to prevent inaccuracies
                    $price = 0;                    
                }
            } else {
                $steamlyticsCSGO = new CSGO(self::STEAMLYTICS_API_KEY);
                try {
                    $prices = $steamlyticsCSGO->getPrices($marketHashName, 'mixed');
                    if ($prices->getVolume() >= 10) {
                        $price = $prices->getMedianPrice();
                    } else {
                        // return a price of 0 if volume is too low, to prevent inaccuracies
                        $price = 0;
                    }
                } catch (SteamlyticsException $ex) {

                }
            }
            return $price;
        }
    }   