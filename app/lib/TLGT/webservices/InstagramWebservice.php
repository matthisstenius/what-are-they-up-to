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
		$instagrams = [];

		foreach ($fromJson['data'] as $key => $value) {
			if ($key >= 9) {
				break;
			}

			$instagrams[] = new \TLGT\models\Instagram($value['images'], $value['tags']);;
		}

		//$this->startSubsceiption($place);
		\Cache::add($place . 'instagrams', $instagrams, 1);

		return $instagrams;
	}

	/**
	 * @todo Try this out on live server
	 * @param  [type] $place [description]
	 * @return [type]        [description]
	 */
	private function startSubsceiption($place) {
		$query = http_build_query(
			array(
				'client_id' => self::$clientID,
				'client_secret' => 'e770c71cee19447c80afd530a35091dc',
				'object' => 'tag',
				'aspect' => 'media',
				'object_id' => str_replace(' ', '', $place),
				'callback_url' => $_SERVER['HTTP_REFERER'] . '/image/callback'
			)
		);

		$url = self::$baseUri . '/subscriptions' . $query;

		try {
			$this->request($url, null, 'POST');
		}

		catch (\Exception $e) {
			throw $e;
		}
	}
}