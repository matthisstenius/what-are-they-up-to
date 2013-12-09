<?php

namespace TLGT\webservices;

class LocationWebservice extends RequestWrapper {
	private static $baseUri = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=';

	/**
	 * Gets long and lat for a given place. A place can be e.g Stockholm
	 * @return string coordinates
	 */
	public function getCoordinates($lookup) {
		$lookup = urlencode($lookup);

		$url = self::$baseUri . $lookup;

		try {
			$result = $this->request($url);
			$fromJson = json_decode($result, true);

			$longitude = null;
			$latitude = null;

			if ($fromJson['status'] != 'ZERO_RESULTS') {
				$longitude = $fromJson['results'][0]['geometry']['location']['lng'];
				$latitude = $fromJson['results'][0]['geometry']['location']['lat'];
			}

			return new \TLGT\models\Location($lookup, $longitude, $latitude);

		}

		catch (\Exception $e) {
			throw $e;
		}
	}
}