@extends('layouts.default')

@section('content')

	<div class="search center">

			<label for="term">Enter a place</label>
			<input type="text" name="term" id="search-term">
		
			<input id="search" type="submit" value="Send">

	</div>
	
	<span class="loading instagram-loading hidden">Loading instagrams...</span>
	<div class="instagramArea clearfix">
	</div>
	
	<span class="loading twitter-loading hidden">Loading tweets...</span>
	<div class="twitterArea clearfix">
	</div>
@stop

