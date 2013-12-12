<?php

class EloquentLocationRepository implements ILocationRepository {
	public function getLocations() {
		return Location::find();
	}

	public function getLocation($place) {
		return Locations::where('place', '=', $place)->first();
	}

	public function addLocation($location) {
		Locations::create([
			'place' => $location->getPlace(), 
			'latitude' => $location->getLongitude(),
			'longitude' => $location->getLatitude()]
		);
	}

	public function updateLocation($place) {

	}

	public function deleteLocation($place) {

	}
}