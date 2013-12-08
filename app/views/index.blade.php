@extends('layouts.default')

@section('content')
	<form action="/place" method="POST">
		<label for="tag">Enter a place</label>
		<input type="text" name="tag" id="tag">

		<input type="submit" value="Send">
	</form>
@stop

