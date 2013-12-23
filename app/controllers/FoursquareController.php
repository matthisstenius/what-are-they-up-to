<?php

class FoursquareController extends BaseController {
	/**
	 * @var TLGT\webservices\FoursquareWebservice
	 */
	private $foursquareWebservice;

	/**
	 * @var TLGT\models\Search
	 */
	private $search;

	/**
	 * @param TLGT\webservices\FoursquareWebservice $foursquareWebservice
	 * @param TLGT\models\Search                    $search
	 */
	public function __construct(TLGT\webservices\FoursquareWebservice $foursquareWebservice,
								TLGT\models\Search $search) {
		$this->foursquareWebservice = $foursquareWebservice;
		$this->search = $search;
	}

	public function getVenues() {
		$search = Input::get('search');

		$longitude = Input::get('longitude');
		$latitude = Input::get('latitude');
		
		if (!$this->search->isTermValid($search)) {
			return Response::json(['error' => 'Please enter a search'], 400);
		}

		if (Cache::has($search . 'venues')) {
			$venues = Cache::get($search . 'venues');
		}

		else {
			$location = new TLGT\models\Location($search, $longitude, $latitude);

			try {
				$venues = $this->foursquareWebservice->getTrendingVenues($location);
			}

			catch (Exception $e) {
				$venues = null;
				$statusCode = 500;
			}
		}

		return Response::json($venues, $statusCode = 200);
	}
}