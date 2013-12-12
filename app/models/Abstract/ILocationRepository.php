<?php

interface ILocationRepository {
	public function getLocations();
	public function getLocation($location);
	public function addLocation($location);
	public function updateLocation($location);
	public function deleteLocation($location);
}