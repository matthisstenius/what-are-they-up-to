<?php

namespace TLGT\models;

class Tweet {
	private $created;

	private $text;

	private $name;	

	public function __construct($created, $text, $name) {
		$this->created = $created;
		$this->text = $text;
		$this->name = $name;
	}

	public function getCreated() {
		return $this->created;
	}

	public function getText() {
		return $this->text;
	}

	public function getName() {
		return $this->name;
	}
}