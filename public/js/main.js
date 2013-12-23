var TLGT = TLGT || {};

TLGT.init = function() {
	this.autocomplete();
};

TLGT.nodes = {
	search: document.getElementById('search'),
	searchInput: $('#search-term'),
	twitterArea: $('.twitterArea'),
	instagramLoading: $('.instagram-loading'),
	twitterLoading: $('.twitter-loading'),
	venuesLoading: $('.venues-loading'),
	venuesArea: $('.venues-area'),
	instagramArea: $('.instagramArea')
};

TLGT.events = {
	
};

TLGT.getTweets = function(request) {
	this.nodes.twitterLoading.removeClass('hidden');

	var xhr = $.ajax({
		url: 'tweets',
		type: 'POST',
		data: request,
		accepts: 'json'
	});

	xhr.done(function(tweets) {
		TLGT.nodes.twitterLoading.addClass('hidden');
		TLGT.renderTweets(tweets);
	});

	xhr.fail(function(err) {
		console.log(err);
	});
};

TLGT.getVenues = function(request) {
	this.nodes.venuesLoading.removeClass('hidden');

	var xhr = $.ajax({
		url: 'venues',
		type: 'POST',
		data: request,
		accepts: 'json'
	});

	xhr.done(function(venues) {
		TLGT.nodes.venuesLoading.addClass('hidden');
		TLGT.renderVenues(venues);
	});

	xhr.fail(function(err) {
		console.log(err);
	});
};

TLGT.getInstagrams = function(request) {
	this.nodes.instagramLoading.removeClass('hidden');

	var xhr = $.ajax({
		url: 'instagrams',
		type: 'POST',
		data: request,
		accepts: 'json'
	});

	xhr.done(function(instagrams) {
		TLGT.nodes.instagramLoading.addClass('hidden');
		TLGT.renderInstagrams(instagrams);
	});

	xhr.fail(function(err) {
		console.log(err);
	});
};

TLGT.renderTweets = function(tweets) {
	var output = '',
		twitterArea = this.nodes.twitterArea;

	twitterArea.empty();

	if (tweets.length > 0) {
		output += '<h2 class="title">This is what they are talking about...</h2>';

		for (var i = 0; i < tweets.length; i++) {
			output += '<div class="tweet col-1-2">'
						+ '<h3>' + tweets[i].name + ' says:</h3>'
						+ '<p>' + tweets[i].text + '</p>'
						+ '<p>' + moment(tweets[i].created).fromNow() + '</p>'
						+ '</div>';
					
		}	
	}
	
	else {
		output = '<h2 class="output-message">We could not find any tweets for your request.</h2>';
	}

	twitterArea.append(output);
};

TLGT.renderVenues = function(venues) {
	this.nodes.venuesArea.empty();

	if (venues.length > 0) {
		this.nodes.venuesArea.append('<h2 class="title">Their favorite venues</h2><div id="map-canvas"></div>');

		var mapOptions = {
			center: new google.maps.LatLng(venues[0].latitude, venues[0].longitude),
			zoom: 13
		};

		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

		for (var i = 0, max = venues.length; i < max; i++) {
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(venues[i].latitude, venues[i].longitude),
				title: venues[i].name,
				map: map
			});

			var infoWindowMessage = '<div>'
									+ '<h2>' + venues[i].name + '</h2>'
									+ '<p>Checkins: ' + venues[i].checkins + '</p>'
									+ '<p>People here now: ' + venues[i].hereNow + '</p>';

			var infowindow = new google.maps.InfoWindow({
				content: infoWindowMessage
			});

			(function(marker, infowindow) {
				google.maps.event.addListener(marker, 'click', function() {
	    			infowindow.open(map,marker);
	  			});	
			})(marker, infowindow);

			marker.setMap(map);
		}	
	}

	else {
		this.nodes.venuesArea.prepend('<h2 class="output-message">No venues could be found</h2>');
	}
	
};

TLGT.renderInstagrams = function(instagrams) {
	var output = '',
		instagramArea = this.nodes.instagramArea;

	instagramArea.empty();

	if (instagrams.length > 0) {
		for (var i = 0; i < instagrams.length; i++) {
			//var tags = '';

			// for (var j = 0; j < instagrams[i].tags.length; j++) {
			// 	tags += '<span class="tag">#' + instagrams[i].tags[j] + '</span>';
			// }

			output += '<div class="pad col-1-3"><div class="pad instagram">'
						+ '<img class="center" src=' + instagrams[i].images.low_resolution.url + '>'
						//+ tags 
						+ '</div></div>';
		}
	}

	else {
		output = 'No instagrams';
	}

	instagramArea.append(output);
};

TLGT.autocomplete = function() {
	var defaultBounds = new google.maps.LatLngBounds(
		new google.maps.LatLng(-90,-180),
		new google.maps.LatLng(-90,-180));

	var input = document.getElementById('search-term');

	var options = {
		bounds: defaultBounds,
		types: ['geocode', 'establishment']
	};

	var autocomplete = new google.maps.places.Autocomplete(input, options);

	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		var place = autocomplete.getPlace();

		var request = {
			search: place.name,
			latitude: place.geometry.location.nb,
			longitude: place.geometry.location.ob
		};

		TLGT.getTweets(request);
		TLGT.getInstagrams(request);
		TLGT.getVenues(request);
	});
};

TLGT.init();