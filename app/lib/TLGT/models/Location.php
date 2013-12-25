<?php

namespace TLGT\models;

class Location {
	private $place;

	private $longitude;

	private $latitude;

	public function __construct($place, $longitude, $latitude) {
		$this->place = htmlspecialchars($place);
		$this->longitude = htmlspecialchars($longitude);
		$this->latitude = htmlspecialchars($latitude);
	}

	public function getPlace() {
		return $this->place;
	}

	public function getLongitude() {
		return $this->longitude;
	}	

	public function getLatitude() {
		return $this->latitude;
	}

	public function coordinatesExist() {
		if ($this->getLongitude() && $this->getLatitude()) {
			return true;
		}

		return false;
	}
}