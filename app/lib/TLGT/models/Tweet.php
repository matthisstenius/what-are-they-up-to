<?php

namespace TLGT\models;

class Tweet {
	/**
	 * @var Date
	 */
	public $created;

	/**
	 * @var string
	 */
	public $text;

	/**
	 * @var string
	 */
	public $name;	

	/**
	 * @param date $created
	 * @param string $text
	 * @param string $name
	 */
	public function __construct($created, $text, $name) {
		$this->created = htmlspecialchars($created);
		$this->text = htmlspecialchars($text);
		$this->name = htmlspecialchars($name);
	}

	/**
	 * @return date
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
}