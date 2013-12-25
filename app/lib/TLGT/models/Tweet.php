<?php

namespace TLGT\models;

class Tweet {
	public $created;

	public $text;

	public $name;	

	public function __construct($created, $text, $name) {
		$this->created = htmlspecialchars($created);
		$this->text = htmlspecialchars($text);
		$this->name = htmlspecialchars($name);
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