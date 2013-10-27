
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

        sess.call('getPosition', {total: api.step.count()}).then(function(data) {
            api.goto(data.position);
        });

        sess.subscribe('presentationControl', function(topic, data) {
            api.goto(data.position);
        });
    }
    , function(code, reason) {
        console.warn('WebSocket connection closed', code, reason);
    }
    , {
        'skipSubprotocolCheck': true
    }
);
