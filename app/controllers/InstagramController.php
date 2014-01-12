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
			return Response::json(array('error' => 'Please enter a search'), 400);
		}

		if (Cache::has($search . 'instagrams')) {
			$instagrams = Cache::get($search . 'instagrams');
		}

		else {
			try {
				$instagrams = $this->instagramWebservice->getImagesByTagName($search);
			}

			catch (Exception $e) {
				$instagrams = null;
				$statusCode = 500;
			}
			
		}

		return Response::json($instagrams, $statusCode = 200);
	}
}