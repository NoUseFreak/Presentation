var sess;
var conn = new ab.connect(
    'ws://' + wsHost
    , function(session) {
        sess = session;

        sess.call('getPosition').then(function(data) {
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

function slideNext() {
    sess.call('presentationControl', {action: 'next'});
    slideCount(slideCount()+1);
}
function slidePrev() {
    sess.call('presentationControl', {action: 'prev'});
    slideCount(slideCount()-1);
}
function slideCount(count) {
    if (count == undefined) {
        return parseInt($('div.slide-count').text());
    }
    $('div.slide-count').text(count);
}

$(function() {
    $('body').on('keydown', function(event) {
        switch (event.keyCode) {
            case 9:
            case 32:
            case 39:
            case 40:
                slideNext();
                return false;

            case 37:
            case 38:
                slidePrev();
                return false;
        }
    });
    $('a.slide-next').on('click', function() {
        slideNext();
    })
    $('a.slide-prev').on('click', function() {
        slidePrev();
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
