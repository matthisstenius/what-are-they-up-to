<?php

namespace TLGT\webservices;

class LocationWebservice extends RequestWrapper {
	private static $baseUri = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=';

	/**
	 * @var string
	 */
	private $lookup;

	/**
	 * @param string $lookup
	 */
	public function __construct($lookup) {
		$this->lookup = $lookup;
	}

	/**
	 * Gets long and lat for a given place. A place can be e.g Stockholm
	 * @return string coordinates
	 */
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