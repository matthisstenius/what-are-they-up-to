<?php

namespace TLGT\models;

class Search {
	public static $rules = ['term' => 'required'];

	/**
	 * @var array
	 */
	public $errors;
	/**
	 * Validates input
	 * @return boolean
	 */
	public function isTagNameValid() {
		$validate = \Validator::make(\Input::all(), self::$rules);

		if ($validate->passes()) {
			return true;
		}

		return false;
	}
}