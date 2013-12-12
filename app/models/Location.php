<?php

class Locations extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'locations';

	protected $fillable = ['place', 'longitude', 'latitude'];
}