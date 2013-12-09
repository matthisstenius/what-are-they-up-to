@extends('layouts.default')

@section('content')
	<form action="/place" method="POST">
		<label for="term">Enter a place</label>
		<input type="text" name="term" id="term">

		<input type="submit" value="Send">
	</form>
@stop

