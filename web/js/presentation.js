
var sess;
var api;
var slide = {
    disableControls: true
};
document.addEventListener("keyup", function ( event ) {
    if (slide.disableControls) {
        event.stopPropagation();
        event.stopImmediatePropagation();
        return false;
    }
});

$(function() {
    api = impress();
    api.init();
    api.goto(0);
});



var conn = new ab.connect(
    'ws://' + wsHost
    , function(session) {            // Once the connection has been established
        sess = session;

        sess.call('getPosition').then(function(data) {
            console.log(data);
        });

        sess.subscribe('presentationControl', function(topic, data) {
            // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
            switch (data.action) {
                case 'next':
                    api.next();
                    break;
                case 'prev':
                    api.prev();
                    break;
            }
        });
    }
    , function(code, reason) {            // When the connection is closed
        console.warn('WebSocket connection closed', code, reason);
    }
    , {                       // Additional parameters, we're ignoring the WAMP sub-protocol for older browsers
        'skipSubprotocolCheck': true
    }
);
