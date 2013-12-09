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

	private $twitterWebservice;

	/**
	 * @param TLGT\models\Search                   $search
	 * @param TLGT\webservices\InstagramWebservice $instagramWebservice
	 */
	public function __construct(TLGT\models\Search $search,
								TLGT\webservices\InstagramWebservice $instagramWebservice,
								TLGT\webservices\TwitterWebservice $twitterWebservice,
								TLGT\webservices\LocationWebservice $locationWebservice) {
		$this->search = $search;
		$this->instagramWebservice = $instagramWebservice;
		$this->twitterWebservice = $twitterWebservice;
		$this->locationWebservice = $locationWebservice;
	}

	public function index()
	{
		return View::make('index');
	}

	public function getPlace() {
		if (!$this->search->isTagNameValid()) {
			return Redirect::back()->withInput()->withErrors($this->search->errors);
		}

		return Redirect::to('place/' . Input::get('term'));
	}

	public function showPlace($place) {
		$location = $this->locationWebservice->getCoordinates($place);

		$instagrams = $this->instagramWebservice->getImagesByTagName($place);
		$tweets = $this->twitterWebservice->getTweetsByLocation($location);

		return View::make('place', ['instagrams' => $instagrams, 'tweets' => $tweets]);
	}
}