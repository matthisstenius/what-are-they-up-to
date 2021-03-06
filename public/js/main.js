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
	instagramArea: $('.instagram-area'),
	token: $('#token')
};

/**
 * Requests tweets
 * @param  object request
 * @return void
 */
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
		TLGT.nodes.twitterArea.empty();
		TLGT.nodes.twitterLoading.addClass('hidden');
		TLGT.renderError(TLGT.nodes.twitterArea, 'Ops.. An error occured while fetching tweets. Please try again later.');
	});
};

/**
 * Requests venues
 * @param  object request
 * @return void
 */
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
		TLGT.nodes.venuesArea.empty();
		TLGT.nodes.venuesLoading.addClass('hidden');
		TLGT.renderError(TLGT.nodes.venuesArea, 'Ops.. An error occured while fetching venues. Please try again later.');
	});
};

/**
 * Requests instagrams
 * @param  object request
 * @return void
 */
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
		TLGT.nodes.instagramArea.empty();
		TLGT.nodes.instagramLoading.addClass('hidden');
		TLGT.renderError(TLGT.nodes.instagramArea, 'Ops.. An error occured while fetching instagrams. Please try again later.');
	});
};

/**
 * Renders tweet on page
 * @param  array tweets
 * @return void
 */
TLGT.renderTweets = function(tweets) {
	var output = '',
		twitterArea = this.nodes.twitterArea,
		twitterWrap = $('.twitter-wrap');

	twitterWrap.addClass('active');
	
	twitterArea.empty();

	if (tweets.length > 0) {
		output += '<h2 class="twitter-title title">This is what they are talking about...</h2>';

		for (var i = 0; i < tweets.length; i++) {
			output += '<div class="tweet col-1-2">'
						+ '<h3>' + tweets[i].name + ' says:</h3>'
						+ '<p>' + tweets[i].text + '</p>'
						+ '<p>' + moment(tweets[i].created).fromNow() + '</p>'
						+ '</div>';
					
		}	
	}
	
	else {
		output = '<h2 class="output-message twitter-title">Sorry. No tweets could be found for your request.</h2>';
	}

	twitterArea.append(output);
};

/**
 * Renders venues onto page
 * @param  array venues
 * @return void
 */
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
		this.nodes.venuesArea.prepend('<h2 class="output-message">Sorry. No venues could be found for your request</h2>');
	}
	
};

TLGT.renderInstagrams = function(instagrams) {
	var output = '',
		instagramArea = TLGT.nodes.instagramArea;

	instagramArea.empty();

	if (instagrams.length > 0) {
		for (var i = 0; i < instagrams.length; i++) {
			output += '<div class="pad col-1-3"><div class="pad instagram">'
						+ '<img class="center" src=' + instagrams[i].images.low_resolution.url + '>'
						+ '</div></div>';
		}
	}

	else {
		output = '<h2 class="output-message">Sorry. No instagrams could be found for your request.</h2>';
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
			latitude: place.geometry.location.d,
			longitude: place.geometry.location.e,
			_token: TLGT.nodes.token[0].value
		};

		TLGT.getTweets(request);
		TLGT.getInstagrams(request);
		TLGT.getVenues(request);
	});
};

TLGT.renderError = function(node, message) {
	node.html('<h3 class="error-message">' + message + '</h3>');
};

TLGT.init();