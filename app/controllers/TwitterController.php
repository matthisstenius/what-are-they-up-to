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
	 * @var TLGT\webservices\LocationWebservice
	 */
	private $locationWebservice;

	/**
	 * @var ILocationRepository
	 */
	private $locationRepository;

	public function __construct(TLGT\models\Search $search,
								TLGT\webservices\TwitterWebservice $twitterWebservice,
								TLGT\webservices\LocationWebservice $locationWebservice,
								EloquentLocationRepository $locationRepository) {
		
		$this->search = $search;
		$this->twitterWebservice = $twitterWebservice;
		$this->locationWebservice = $locationWebservice;
		$this->locationRepository = $locationRepository;
	}

	public function getTweets() {
		$search = Input::get('search');
		$longitude = Input::get('longitude');
		$latitude = Input::get('latitude');
		
		if (!$this->search->isTermValid($search)) {
			return Response::json(['error' => 'Please enter a search'], 400);
		}

		// if ($cachedLocation = $this->locationRepository->getLocation($search)) {
		// 	$location = new TLGT\models\Location($cachedLocation->place, 
		// 										$cachedLocation->latitude,
		// 										$cachedLocation->longitude);
		// }

		// else {
		// 	$location = $this->locationWebservice->getCoordinates($search);

		// 	if ($location->coordinatesExist()) {
		// 		$this->locationRepository->addLocation($location);
		// 	}
		// }
		$location = new TLGT\models\Location($search, $longitude, $latitude);

		$tweets = $this->twitterWebservice->getTweetsByLocation($location);

		return Response::json($tweets);
	}


}