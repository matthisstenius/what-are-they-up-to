@extends('layouts.default')

@section('content')
	@if (count($instagrams) > 0)
		@foreach($instagrams as $instagram)
			<img src={{$instagram->getImages()['low_resolution']['url']}} alt="">
		@endforeach
	@else
		<p>No images found</p>
	@endif

	@if (count($tweets) > 0)
		@foreach($tweets as $tweet)
			<p>{{$tweet->getText()}}</p>
		@endforeach
	@else
		<p>No tweets found</p>
	@endif	
@endsection