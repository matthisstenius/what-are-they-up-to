var TLGT = TLGT || {};

TLGT.init = function() {
	TLGT.nodes.search.addEventListener('click', function(e) {
		e.preventDefault();
		var search = TLGT.nodes.searchInput.val(); 

		TLGT.getTweets(search);
		TLGT.getInstagrams(search);

		search = "";
	}, false);
};

TLGT.nodes = {
	search: document.getElementById('search'),
	searchInput: $('#search-term'),
	twitterArea: $('.twitterArea'),
	instagramArea: $('.instagramArea')
};

TLGT.events = {
	
};

TLGT.getTweets = function(search) {
	var xhr = $.ajax({
		url: 'tweets',
		type: 'POST',
		data: {search: search},
		accepts: 'json'
	});

	xhr.done(function(tweets) {
		TLGT.renderTweets(tweets);
	});

	xhr.fail(function(err) {
		console.log(err);
	});
};

TLGT.getInstagrams = function(search) {
	var xhr = $.ajax({
		url: 'instagrams',
		type: 'POST',
		data: {search: search},
		accepts: 'json'
	});

	xhr.done(function(instagrams) {
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
			output += '<div class="instagram">'
						+ '<img src=' + instagrams[i].images.low_resolution.url + '>'
						+ '</div>';
		}
	}

	else {
		output = 'No instagrams';
	}

	instagramArea.append(output);
};

TLGT.init();