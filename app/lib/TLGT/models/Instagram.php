<?php

namespace TLGT\models;

class Instagram {
	/**
	 * @var array
	 */
	public $images;

	/**
	 * @var array
	 */
	public $tags;

	/**
	 * @param array $images
	 * @param string $text
	 */
	public function __construct($images, $tags) {
		$this->images = htmlspecialchars($images);
		$this->tags = htmlspecialchars($tags);
	}

	/**
	 * @return array
	 */
	public function getImages() {
		return $this->images;
	}
}