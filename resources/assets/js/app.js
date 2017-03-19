require('./libraries');

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');




window.Pusher = require('pusher-js');

var pusher = new Pusher('bbadb783c3924ad225f7', {encrypted: true});

// Pusher.logToConsole = true;

var channel = pusher.subscribe('visitor-activity');
channel.bind('comment', function(data) {
    console.debug(data);
    $("#new-comment").show();
});
