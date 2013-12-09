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

		try {
			$url = self::$baseUri . "tags/" . $place . "/media/recent?client_id=" . self::$clientID;

			$response = $this->request($url);

			$fromJson = json_decode($response, true);
			$instagrams = [];

			foreach ($fromJson['data'] as $key => $value) {
				if ($key > 6) {
					break;
				}

				$instagrams[] = new \TLGT\models\Instagram($value['images']);;
			}

			//$this->startSubsceiption($place);

			return $instagrams;
		}

		catch (\Exception $e) {
			throw $e;
		}
	}

	// public function getUser($user) {
	// 	$url = self::$baseUri . "users/search?q=" . $user . "&client_id=" . self::$clientID;

	// 	try {
	// 		$user = $response = $this->request($url);
			
	// 		$fromJson = json_decode($response, true);
	// 		$this->getImagesByUser($fromJson['data'][0]['id']);
	// 	}

	// 	catch (\Exception $e) {
	// 		dd($e->getMessage());
	// 	}
	// }

	// public function getImagesByUser($userId) {
	// 	$url = self::$baseUri . '/users/' . $userId  . "/media/recent/?client_id=" . self::$clientID;

	// 	try {
	// 		$response = $this->request($url);
	// 		dd(json_decode($response));
	// 	}

	// 	catch (\Exception $e) {
	// 		dd($e->getMessage());
	// 	}
	// }

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