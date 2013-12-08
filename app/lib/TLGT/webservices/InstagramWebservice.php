<?php

namespace TLGT\webservices;

class InstagramWebservice extends RequestWrapper {
	private static $clientID = "db101a014eeb48b789e1da8a6925481d";
	private static $baseUri = "https://api.instagram.com/v1/";

	/**
	 * @var array
	 */
	public $errors;

	/**
	 * @param string $place
	 * @return array of \TLGT\models\Instagram
	 */
	public function getImagesByTagName($place) {
		$place = str_replace(' ', '', $place);

		try {
			$response = $this->request(self::$baseUri . "tags/" . $place . "/media/recent?client_id=" . self::$clientID);
			$fromJson = json_decode($response, true);
			$instagrams = [];

			foreach ($fromJson['data'] as $value) {
				$instagrams[] = new \TLGT\models\Instagram($value['images']);;
			}

			return $instagrams;
		}

		catch (\Exception $e) {
			dd($e->getMessage());
		}
	}
}