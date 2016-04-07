var color = [
    [1,'red'],
    [14,'black'],
    [2,'red'],
    [13,'black'],
    [3,'red'],
    [12,'black'],
    [4,'red'],
    [0,'green'],
    [11,'black'],
    [5,'red'],
    [10,'black'],
    [6,'red'],
    [9,'black'],
    [7,'red'],
    [8,'black']
];

function WIN_MASS(number){
    switch(number){
        case 0: return 7; break;
        case 1: return 0; break;
        case 2: return 2; break;
        case 3: return 4; break;
        case 4: return 6; break;
        case 5: return 9; break;
        case 6: return 11; break;
        case 7: return 13; break;
        case 8: return 14; break;
        case 9: return 12; break;
        case 10: return 10; break;
        case 11: return 8; break;
        case 12: return 5; break;
        case 13: return 3; break;
        case 14: return 1; break;
    }
}

Array.prototype.mul = function(k) {
    var res = [];
    for (var i = 0; i < k; i++) res = res.concat(this.slice(0));
    return res;
}

var carousel = color.mul(20);
var elem = '';

for(var yi = 1; yi < carousel.length; yi++) {
    elem += '<span class="item item-'+carousel[yi][1]+'">';
    elem += '<span class="rollitem">';
    elem += carousel[yi][0];
    elem += '</span>';
    elem += '</span>';
}
$(document).ready(function(){
    $('#roulette .carusel').html(elem);
});

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function WIN(number){
    var _width = $('#roulette').css('width').split("px");
    var num_elem_center = Math.ceil((_width[0] / 75) / 2);
    var bar = ((_width[0] / 2) - (num_elem_center * 75)) / 2;
    var _default = 8970;
    var win = _default - bar + (75 * (number - num_elem_center));
    return win;
}

function RouletteStart(win){
    var rand = WIN(WIN_MASS(win));
    $('.carusel').css({'transform': 'none','transition': 'none'});
    setTimeout(function(){$('.carusel').css({'transform': 'translate3d(-'+getRandomInt(rand, rand)+'px, 0px, 0px)', 'transition':'6s ease'})}, 30);
    $('#roulette-start').trigger("play");
    RouletteFinish(win);
}

function RouletteFinish(win){
    $('.carusel').one('transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', function(e) {
        $('#roulette-finish').trigger("play");
        $('#past div:first').remove();
        $('#past').append('<div class="ball ball-'+color[WIN_MASS(win)][1]+'">'+color[WIN_MASS(win)][0]+'</div>');
    });
}



(function($) {
    $.fn.countdown = function(prop) {
        var options = $.extend({
            seconds: 0,
            freeze: false
        }, prop);
        var left, m, s, positions;
        init(this, options);
        positions = this.find(".position");
        var start = Math.floor(new Date / 1e3);
        (function tick() {
            left = start - Math.floor(new Date / 1e3) + options.seconds;
            if (left < 0) {
                left = 0
            }
            m = Math.floor(left / 60);
            updateDuo(0, 1, m);
            s = left - m * 60;
            updateDuo(2, 3, s);
            if (!options.freeze) setTimeout(tick, 1e3)
        })();

        function updateDuo(minor, major, value) {
            switchDigit(positions.eq(minor), Math.floor(value / 10) % 10);
            switchDigit(positions.eq(major), value % 10)
        }
        return this
    };

    function init(elem, options) {
        elem.addClass("countdownHolder");
        $.each(["Minutes", "Seconds"],
            function(i) {
                $('<span class="count' + this + '"><span class="position"><span class="digit static">0</span></span><span class="position"><span class="digit static">0</span></span></span>').appendTo(elem);
                if (this != "Seconds") {
                    elem.append('<span class="countDiv countDiv' + i + '">:</span>')
                }
            })
    }

    function switchDigit(position, number) {
        var digit = position.find(".digit");
        if (digit.is(":animated")) {
            return false
        }
        if (position.data("digit") == number) {
            return false
        }
        position.data("digit", number);
        var replacement = $("<span>", {
            "class": "digit",
            css: {
                //  top: "-2.1em",
                //   opacity: 0
            },
            html: number
        });
        digit.before(replacement).removeClass("static").animate({
            //    top: "2.5em",
            // opacity: 0
        }, "fast", function() {
            digit.remove()
        });
        replacement.delay(100).animate({
            //  top: 0,
            // opacity: 1
        }, "fast", function() {
            //  replacement.addClass("static")
        })
    }
})(jQuery);