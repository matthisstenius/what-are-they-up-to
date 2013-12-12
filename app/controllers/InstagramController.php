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

	public function getInstagrams($search) {
		if (Cache::has('instagrams')) {
			$instagrams = Cache::get('instagrams');
		}

		else {
			$instagrams = $this->instagramWebservice->getImagesByTagName($search);
		}

		return Response::json($instagrams);
	}
}