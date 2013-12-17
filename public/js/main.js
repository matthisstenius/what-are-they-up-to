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
		for (var i = 0; i < tweets.length; i++) {
			output += '<div class="tweet">'
						+ '<p>' + tweets[i].name + '</p>'
						+ '<p>' + tweets[i].text + '</p>'
						+ '<p>' + tweets[i].created + '</p>'
						+ '</div>';
					
		}	
	}
	
	else {
		output = 'No tweets';
	}

	twitterArea.append(output);
};

TLGT.renderInstagrams = function(instagrams) {
	var output = '',
		instagramArea = this.nodes.instagramArea;

	instagramArea.empty();

	if (instagrams.length > 0) {
		for (var i = 0; i < instagrams.length; i++) {
			output += '<div class="pad col-1-3"><div class="instagram">'
						+ '<img src=' + instagrams[i].images.low_resolution.url + '>'
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
	});
};

TLGT.init();