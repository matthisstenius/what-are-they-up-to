<?php

namespace TLGT\webservices;

class LocationWebservice extends RequestWrapper {
	private static $baseUri = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=';
	private $lookup;

	public function __construct($lookup) {
		$this->lookup = $lookup;
	}

	public function getCoordinates() {
		$url = self::$baseUri . $this->lookup;

		try {
			$result = $this->request($url);
			$fromJson = json_decode($result, true);

			return $fromJson['results'][0]['geometry']['location'];

		}

		catch (\Exception $e) {

		}
	}
}