<?php

class TwitterController extends BaseController {
	/**
	 * @var TLGT\models\Search
	 */
	private $search;

	/**
	 * @var TLGT\webservices\TwitterWebservice
	 */
	private $twitterWebservice;

	/**
	 * @param TLGT\models\Search                  $search
	 * @param TLGT\webservices\TwitterWebservice  $twitterWebservice
	 * @param TLGT\webservices\LocationWebservice $locationWebservice
	 */
	public function __construct(TLGT\models\Search $search,
								TLGT\webservices\TwitterWebservice $twitterWebservice) {
		
		$this->search = $search;
		$this->twitterWebservice = $twitterWebservice;
	}

	public function getTweets() {
		$search = Input::get('search');
		$longitude = Input::get('longitude');
		$latitude = Input::get('latitude');
		
		if (!$this->search->isTermValid($search)) {
			return Response::json(array('error' => 'Please enter a valid search'), 400);
		}

		if (Cache::has($search . 'tweets')) {
			$tweets = Cache::get($search . 'tweets');
		}

		else {
			$location = new TLGT\models\Location($search, $longitude, $latitude);

			try {
				$tweets = $this->twitterWebservice->getTweetsByLocation($location);
			}

			catch (Exception $e) {
				$tweets = null;
				$statusCode = 500;
			}
		}

		return Response::json($tweets, $statusCode = 200);
	}


}