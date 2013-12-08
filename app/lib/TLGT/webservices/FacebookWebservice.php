<?php

namespace TLGT\webservices;

class FacebookWebservice extends RequestWrapper {
	private static $baseUri = "https://graph.facebook.com/search?";

	public function getContentByCoordinates($place) {
		$locationWebservice = new LocationWebservice($place);
		$coordinates = $locationWebservice->getCoordinates();
		$coordinateString = $coordinates['lat'] . "," . $coordinates['lng'];

		$query = http_build_query(
			array(
				'q' => 'museum',
				'type' => 'place',
				'center' => $coordinateString,
				'limit' => '20',
				'access_token' => \Config::get('facebook.AccessToken'),
			)
		);

		$url = self::$baseUri . $query;
								
		try {
			$result = $this->request($url);
			dd(json_decode($result));
		}
		
		catch (\Exception $e) {
			dd($e->getMessage());
		}
	}
}