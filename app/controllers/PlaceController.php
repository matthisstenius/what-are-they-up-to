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

	private $facebookWebservice;

	/**
	 * @param TLGT\models\Search                   $search
	 * @param TLGT\webservices\InstagramWebservice $instagramWebservice
	 */
	public function __construct(TLGT\models\Search $search,
								TLGT\webservices\InstagramWebservice $instagramWebservice,
								TLGT\webservices\FacebookWebservice $facebookWebservice) {
		$this->search = $search;
		$this->instagramWebservice = $instagramWebservice;
		$this->facebookWebservice = $facebookWebservice;
	}

	public function index()
	{
		return View::make('index');
	}

	public function getPlace() {
		if (!$this->search->isTagNameValid()) {
			return Redirect::back()->withInput()->withErrors($this->instagramWebservice->errors);
		}

		return Redirect::to('place/' . Input::get('tag'));
	}

	public function showPlace($place) {
		$instagram = $this->instagramWebservice->getImagesByTagName($place);
		$facebookMeta = $this->facebookWebservice->getContentByCoordinates($place);

		return View::make('place', ['instagrams' => $instagram]);
	}
}