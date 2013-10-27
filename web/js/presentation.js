
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
    , function(session) {
        sess = session;

        sess.call('getPosition').then(function(data) {
            api.goto(data.position);
        });

        sess.subscribe('presentationControl', function(topic, data) {
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
    , function(code, reason) {
        console.warn('WebSocket connection closed', code, reason);
    }
    , {
        'skipSubprotocolCheck': true
    }
);
