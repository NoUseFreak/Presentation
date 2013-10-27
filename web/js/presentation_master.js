var PresentationMaster = function() {

    var session;
    var conn;

    var init = function() {
        init_connection();
    }

    var init_connection = function() {
        conn = new ab.connect(
            'ws://' + wsHost
            , function(s) {
                session = s;

                session.call('getPosition').then(function(data) {
                    slideCount(data.position + 1);
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

    var next = function(callback) {
        session.call('presentationControl', {action: 'next'}).then(function(data) {
            if (callback) {
                callback(data.position);
            }
            slideCount(data.position + 1);
        });
    }

    var prev = function(callback) {
        session.call('presentationControl', {action: 'prev'}).then(function(data) {
            if (callback) {
                callback(data.position);
            }
            slideCount(data.position + 1);
        });
    }

    return {
        'init': init,
        'next': next,
        'prev': prev
    };
}

var press = new PresentationMaster();
press.init();

$(function() {
    function slideCount(count) {
        $('div.slide-count').text(count);
    }

    $('body').on('keydown', function(event) {
        switch (event.keyCode) {
            case 9:
            case 32:
            case 39:
            case 40:
                press.next();
                return false;

            case 37:
            case 38:
                press.prev();
                return false;
        }
    });
    $('a.slide-next').on('click', function() {
        press.next(function(count) {
            slideCount(count+1);
        });
    })
    $('a.slide-prev').on('click', function() {
        press.prev(function(count) {
            slideCount(count+1);
        });
    })
    $('a.control').on('click', function() {
        $(this).toggleClass('on');
        if ($(this).find('span').text() == 'on') {
            $(this).find('span').text('off');
        }
        else {
            $(this).find('span').text('on');
        }
    })
});

