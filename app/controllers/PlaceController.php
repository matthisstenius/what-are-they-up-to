<?php

//use TLGT\webservices;

class PlaceController extends BaseController {
	/**
	 * @var TLGT\models\Search
	 */
	private $search;

	/**
	 * @var TLGT\webservices\InstagramWebservice
	 */
	private $instagramWebservice;

	/**
	 * @var TLGT\webservices\TwitterWebservice
	 */
	private $twitterWebservice;

	/**
	 * @var ILocationRepository
	 */
	private $locationRepository;

	/**
	 * @param TLGT\models\Search                   $search
	 * @param TLGT\webservices\InstagramWebservice $instagramWebservice
	 */
	public function __construct(TLGT\models\Search $search,
								TLGT\webservices\InstagramWebservice $instagramWebservice,
								TLGT\webservices\TwitterWebservice $twitterWebservice,
								TLGT\webservices\LocationWebservice $locationWebservice,
								EloquentLocationRepository $eloquentlocationRepository) {
		$this->search = $search;
		$this->instagramWebservice = $instagramWebservice;
		$this->twitterWebservice = $twitterWebservice;
		$this->locationWebservice = $locationWebservice;
		$this->locationRepository = $eloquentlocationRepository;
	}

	/**
	 * GET /
	 */
	public function index()
	{
		return View::make('index');
	}

	/**
	 * POST /place
	 * @return [type] [description]
	 */
	public function getPlace() {
		if (!$this->search->isTagNameValid()) {
			return Redirect::back()->withInput()->withErrors($this->search->errors);
		}

		return Redirect::to('place/' . Input::get('term'));
	}

	/**
	 * GET /palce/{place}
	 * @param  string $place
	 */
	public function showPlace($place) {
		if (Cache::has('instagrams')) {
			$instagrams = Cache::get('instagrams');
		}

		else {
			$instagrams = $this->instagramWebservice->getImagesByTagName($place);
		}

		if ($cachedLocation = $this->locationRepository->getLocation($place)) {
			$location = new TLGT\models\Location($cachedLocation->place, 
												$cachedLocation->latitude,
												$cachedLocation->longitude);
		}

		else {
			$location = $this->locationWebservice->getCoordinates($place);

			if ($location->coordinatesExist()) {
				$this->locationRepository->addLocation($location);
			}
		}

		dd($instagrams);
		$tweets = $this->twitterWebservice->getTweetsByLocation($location);

		return View::make('place', ['instagrams' => $instagrams, 'tweets' => $tweets]);
	}
}