<?php

namespace TLGT\models;

class Search {
	public static $rules = ['tag' => 'required'];
	
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