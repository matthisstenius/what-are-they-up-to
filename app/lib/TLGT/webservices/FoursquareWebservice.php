<?php

namespace TLGT\webservices;

class FoursquareWebservice extends RequestWrapper {
	private static $baseUri = 'https://api.foursquare.com/v2/venues/trending?';

	/**
	 * Gets trending venues from Foursquare
	 * @param  TLGT\models\Location $location
	 * @param  integer            $limit
	 * @return array of \TLGT\models\Foursquare
	 */
	public function getTrendingVenues(\TLGT\models\Location $location, $limit = 10) {
		$query = http_build_query([
			'limit' => $limit,
			'll' => $location->getLatitude() . ',' . $location->getLongitude(),
			'client_id' => \Config::get('foursquare.client_id'),
			'client_secret' => \Config::get('foursquare.client_secret')
		]);

		$url = self::$baseUri . $query;
		$response = $this->request($url);
		
		$fromJson = json_decode($response, true);
		$venues = [];

		foreach ($fromJson['response']['venues'] as $key => $venue) {
			$venues[] = new \TLGT\models\Foursquare($venue['name'],
													$venue['location']['lat'],
													$venue['location']['lng'],
													$venue['stats']['checkinsCount'],
													$venue['hereNow']['count']);
		}

		// Cache venues for one minute
		\Cache::add($location->getPlace() . 'venues', $venues, 1);
		
		return $venues;
	}
}