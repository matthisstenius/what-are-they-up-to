<?php

//use TLGT\webservice;

class HomeController extends BaseController {

	public function index()
	{
		return View::make('index');
	}
}