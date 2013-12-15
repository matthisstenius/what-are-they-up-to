@extends('layouts.default')

@section('content')

	<div class="search center">
		<form action="/place" method="POST">
			<label for="term">Enter a place</label>
			<input type="text" name="term" id="search-term">
		
			<input id="search" type="submit" value="Send">
		</form>
	</div>

	<div class="instagramArea"></div>

	<div class="twitterArea"></div>
@stop

