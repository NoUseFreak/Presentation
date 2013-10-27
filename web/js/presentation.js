
var PresentationClient = function() {

    var conn;
    var session;
    var api;
    var settings = {
        'disableControls': true
    };

    var init = function() {
        init_impressjs();
        init_connection();
        init_controls();
    }

    var init_connection = function() {
        conn = new ab.connect(
            'ws://' + wsHost
            , function(s) {
                session = s;

                session.call('getPosition', {total: api.step.count()}).then(function(data) {
                    api.goto(data.position);
                });

                session.subscribe('presentationControl', function(topic, data) {
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
    }

    var init_impressjs = function() {
        $(function() {
            api = impress();
            api.init();
            api.goto(0);
        });
    }

    var init_controls = function() {
        document.addEventListener("keyup", function ( event ) {
            if (settings.disableControls) {
                event.stopPropagation();
                event.stopImmediatePropagation();
                return false;
            }
        });
    }

    var toggleControls = function() {
        settings.disableControls = !settings.disableControls;
    }

    return {
        'init': init,
        'toggleControls': toggleControls
    };
}

var press = new PresentationClient();
press.init();

