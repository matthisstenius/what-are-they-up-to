@extends('layouts.default')

@section('content')
	<div class="grid">
		<div class="search-area center">
			<input type="text" name="term" class="search-input" id="search-term">
			<input id="search" class="hidden" type="submit" value="Send">
		</div>
	</div>
	
	<span class="loading instagram-loading hidden">Loading instagrams...</span>

	<div class="instagramArea pad grid"></div>
	
	<span class="loading twitter-loading hidden">Loading tweets...</span>
	
	<div class="twitter-wrap">
		<div class="twitterArea pad grid"></div>
	</div>
@stop

