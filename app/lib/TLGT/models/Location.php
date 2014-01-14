<?php

namespace TLGT\models;

class Location {
	/**
	 * @var string
	 */
	private $place;

	/**
	 * @var string
	 */
	private $longitude;

	/**
	 * @var string
	 */
	private $latitude;

	/**	
	 * @param string $place
	 * @param string $longitude
	 * @param string $latitude
	 */
	public function __construct($place, $longitude, $latitude) {
		$this->place = htmlspecialchars($place);
		$this->longitude = htmlspecialchars($longitude);
		$this->latitude = htmlspecialchars($latitude);
	}

	/**
	 * @return string
	 */
	public function getPlace() {
		return $this->place;
	}

	/**
	 * @return string
	 */
	public function getLongitude() {
		return $this->longitude;
	}	

	/**
	 * @return string
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * @return boolean
	 */
	public function coordinatesExist() {
		if ($this->getLongitude() && $this->getLatitude()) {
			return true;
		}

		return false;
	}
}