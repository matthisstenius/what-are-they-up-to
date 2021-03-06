<?php

namespace TLGT\models;

class Foursquare {
	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $latitude;

	/**
	 * @var string
	 */
	public $longitude;

	/**
	 * @var string
	 */
	public $checkins;

	/**
	 * @var string
	 */
	public $hereNow;

	/**
	 * @param string $name
	 * @param string $latitude
	 * @param string $longitude
	 * @param string $checkins
	 * @param string $hereNow
	 */
	public function __construct($name, $latitude, $longitude, $checkins, $hereNow) {
		$this->name = htmlspecialchars($name);
		$this->latitude = htmlspecialchars($latitude);
		$this->longitude = htmlspecialchars($longitude);
		$this->checkins = htmlspecialchars($checkins);
		$this->hereNow = htmlspecialchars($hereNow);
	}
}