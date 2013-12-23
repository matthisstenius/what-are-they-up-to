@extends('layouts.default')

@section('content')
	<div class="grid">
		<div class="search-area center">
			<input type="text" name="term" class="search-input" id="search-term">
			<input id="search" class="hidden" type="submit" value="Send">
		</div>

		<h1 class="intro">Enter a location above and see what they are up to.</h1>
	</div>
	
	<div class="grid">
		<p class="center instagram-loading hidden">Loading Instagrams <span class="loading"></span></p>
	</div>

	<div class="instagram-area pad grid"></div>
	
	<div class="twitter-wrap">
		<div class="grid">
			<p class="center twitter-loading hidden">Loading Tweets <span class="loading"></span></p>
		</div>
		<div class="twitterArea pad grid">
			
		</div>
	</div>
	
	<div class="grid">
		<p class="center venues-loading hidden">Loading venues <span class="loading"></span></p>
	</div>

	<div class="venues-area pad grid"></div>
@stop
