<?php

namespace TLGT\webservices;

class RequestWrapper {
	/**
	 * Makes a CURL request
	 * @param  string $url
	 * @param string $authHeader Authentication header required for some requests
	 * @param string $method
	 * @return mixed response from request
	 * @throws Exception if response is not ok
	 */
	public function request($url, $authHeader = null, $method = null) {
		$request = curl_init();
		curl_setopt($request, CURLOPT_URL, $url);
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

		if ($authHeader) {
			curl_setopt($request, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $authHeader));			
		}
		
		if ($method) {
			curl_setopt($request, CURLOPT_POST, true);
		}

		$response = curl_exec($request);

		$statusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
		curl_close($request);

		if ($statusCode == "200") {
			return $response;
		}

		throw new \Exception("Error Processing Request $response");
	}
}