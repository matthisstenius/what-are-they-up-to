<?php

namespace TLGT\models;

class Search {
	/**
	 * Validates input
	 * @return boolean
	 */
	public function isTermValid($term) {
		if ($term != "") {
			return true;
		}

		return false;
	}
}