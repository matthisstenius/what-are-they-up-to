<?php

namespace TLGT\models;

class Instagram {
	/**
	 * @var array
	 */
	private $images;

	/**
	 * @param array $images
	 */
	public function __construct($images) {
		$this->images = $images;
	}

	/**
	 * @return array
	 */
	public function getImages() {
		return $this->images;
	}
}