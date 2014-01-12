<?php

namespace TLGT\webservices;

class InstagramWebservice extends RequestWrapper {
	private static $clientID = "db101a014eeb48b789e1da8a6925481d";
	private static $baseUri = "https://api.instagram.com/v1/";

	/**
	 * @param string $place
	 * @return array of \TLGT\models\Instagram
	 */
	public function getImagesByTagName($place) {
		$place = str_replace(' ', '', $place);

		$url = self::$baseUri . "tags/" . $place . "/media/recent?client_id=" . self::$clientID;

		$response = $this->request($url);

		$fromJson = json_decode($response, true);
		$instagrams = array();

		foreach ($fromJson['data'] as $key => $value) {
			if ($key >= 9) {
				break;
			}

			$instagrams[] = new \TLGT\models\Instagram($value['images'], $value['tags']);;
		}

		// Cache instagrams for one minute
		\Cache::add($place . 'instagrams', $instagrams, 1);

		return $instagrams;
	}
}