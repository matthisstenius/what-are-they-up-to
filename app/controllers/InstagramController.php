<?php

class InstagramController extends BaseController {
	/**
	 * @var TLGT\models\Search
	 */
	private $search;

	/**
	 * @var TLGT\webservices\InstagramWebservice
	 */
	private $instagramWebservice;

	public function __construct(TLGT\models\SEarch $search,
								TLGT\webservices\InstagramWebservice $instagramWebservice) {

		$this->search = $search;
		$this->instagramWebservice = $instagramWebservice;
	}

	public function getInstagrams() {
		$search = Input::get('search');

		if (!$this->search->isTermValid($search)) {
			return Response::json(['error' => 'Please enter a search'], 400);
		}

		if (Cache::has($search . 'instagrams')) {
			$instagrams = Cache::get($search . 'instagrams');
		}

		else {
			$instagrams = $this->instagramWebservice->getImagesByTagName($search);
		}

		return Response::json($instagrams);
	}
}