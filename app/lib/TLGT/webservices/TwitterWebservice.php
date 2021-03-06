<?php

namespace TLGT\webservices;

class TwitterWebservice extends RequestWrapper {
	private static $accessTokenSession = 'twitter::accessToken';
	private static $baseUri = 'https://api.twitter.com/1.1/search/tweets.json?';

	/**
	 * Gets tweets based on location
	 * @param  string $place
	 * @return array of \TLGT\models\Tweet
	 */
	public function getTweetsByLocation(\TLGT\models\Location $location) {
		if ($location->coordinatesExist()) {
			$coordinateString = $location->getLatitude() . ',' . $location->getLongitude() . ',2km';

			$query = http_build_query(
				array(
					'q' => urlencode($location->getPlace()),
					'geocode' => $coordinateString,
					'count' => '10'
				)
			);			
		}

		else {
			$query = http_build_query(
				array(
					'q' => urlencode($location->getPlace()),
					'count' => '10'	
				)
			);
		}


		$result = $this->request(self::$baseUri . $query, $this->getAccessToken());

		$fromJson = json_decode($result, true);

		$tweets = array();

		foreach ($fromJson['statuses'] as $tweet) {
			$tweets[] = new \TLGT\models\Tweet($tweet['created_at'], $tweet['text'], $tweet['user']['name']);
		}

		// Cache tweets for one minute
		\Cache::add($location->getPlace() . 'tweets', $tweets, 1);

		return $tweets;
	}

	/**
	 * Gets token from session or requests a new token
	 * @return string Accesstoken
	 */
	private function getAccessToken() {
		if (!isset($SESSION[self::$accessTokenSession])) {
			try {
				$this->twitterAuthorize();
			}

			catch (\Exception $e) {

			}
		}

		return $_SESSION[self::$accessTokenSession];
	}

	/**
	 * Requests an acces token from Twitter and caches it in the session
	 * @throws Exception If token could not be requested
	 */
	private function twitterAuthorize() {
		$consumerKey = urlencode(\Config::get('twitter.consumerKey'));
		$consumerSecret = urlencode(\Config::get('twitter.consumerSecret'));

		$authToken = $consumerKey . ':' . $consumerSecret;
		$authToken = base64_encode($authToken);

		$request = curl_init();

		$options = array(
			CURLOPT_URL => 'https://api.twitter.com/oauth2/token',
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic ' . $authToken,
				'Content-Type: application/x-www-form-urlencoded;charset=UTF-8')
		);
		
		curl_setopt_array($request, $options);
		$response = curl_exec($request);

		$statusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
		curl_close($request);

		if ($statusCode == "200") {
			$accessToken = json_decode($response, true);

			$_SESSION[self::$accessTokenSession] = $accessToken['access_token'];
		}

		throw new \Exception("Error Processing Request: $response");
		
	}
}