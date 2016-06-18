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

	    // We cache the pricelist because it's only updated daily.
	    // Twice a day, I run a script that calls this function
	    // to fetch a fresh copy of the pricelist.
	    public static function cachePricelist()
	    {
	        try {
	            $steamlyticsCSGO = new CSGO(self::STEAMLYTICS_API_KEY);
	            $pricelist = $steamlyticsCSGO->getPricelist();
	            Cache::forever('pricelist', $pricelist);
	            return $pricelist;
	        } catch (\Exception $ex) {
	            return null;
	        }
	    }

	    /**
	     * @param string $marketHashName
	     * @param Pricelist $pricelist
	     * @return float
	     */
	    public static function getPrice($marketHashName, $pricelist = null) {
	        $cacheKey = "price-{$marketHashName}";
	        if (Cache::has($cacheKey)) {
	            return Cache::get($cacheKey);
	        }
	        return self::cachePrice($marketHashName, $pricelist);
	    }

	    // Prices for individual items should also be cached due to the
	    // extra API calls that may be made.
	    // I have it cached for 12 hours.
	    public static function cachePrice($marketHashName, $pricelist = null) {
	        $cacheKey = "price-{$marketHashName}";
	        $amount = self::fetchPrice($marketHashName, $pricelist);
	        Cache::put($cacheKey, $amount, 12 * 60);
	        return $amount;
	    }

	    public static function fetchPrice($marketHashName, $pricelist = null) {
	        if ($pricelist == null) {
	            $pricelist = self::getPricelist();
	        }
	        // We want to make sure that the price doesn't deviate too much, so
	        // we keep expanding the timespan until we find a price with a deviation percentage
	        // of 50% or less.
	        // Of course you can change this value as necessary, and even implement other conditions
	        // such as checking volume and the first_seen timestamp
	        if ($pricelist != null && $pricelist->doesItemExist($marketHashName)) {
	            $price = $pricelist->getPrice($marketHashName);            
	            if ($price->getVolume() > 1 && $price->getDeviationPercentage() <= 0.5) {
	                return $price->getMedianPrice();
	            }
	        }
	        $steamlyticsCSGO = new CSGO(self::STEAMLYTICS_API_KEY);
	        try {
	            $price = $steamlyticsCSGO->getPrice($marketHashName, 'mixed', '3days');
	            if ($price->getVolume() > 1 && $price->getDeviationPercentage() <= 0.5) {
	                return $price->getMedianPrice();
	            }

	            $price = $steamlyticsCSGO->getPrice($marketHashName, 'mixed', '1week');
	            if ($price->getVolume() > 1 && $price->getDeviationPercentage() <= 0.5) {
	                return $price->getMedianPrice();
	            }

	            $price = $steamlyticsCSGO->getPrice($marketHashName, 'mixed', '1month');
	            if ($price->getVolume() > 1 && $price->getDeviationPercentage() <= 0.5) {
	                return $price->getMedianPrice();
	            }

	            $price = $steamlyticsCSGO->getPrice($marketHashName, 'mixed');
	            if ($price->getVolume() > 1 && $price->getDeviationPercentage() <= 0.5) {
	                return $price->getMedianPrice();
	            }
	        } catch (SteamlyticsException $ex) {

	        }
	        return 0;
	    }
	}   