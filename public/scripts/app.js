/*
 Автор : ДикиЙ
 Дата : 25.03.2016 8:53
 Skype : kudo070
 VK : vk.com/kudo070
 Mail : islam7450@yandex.ru
 Все права принадлежат мне , любое копирование без моего разрешение карается римнём по попе .
 Что вы тут забыли  ? Кыш кыш .
 */
$(document).ready(function () {
    $('.game-selector-item[data-room-name="fast"]').click(function (e) {
        var newroom = new Audio();
        newroom.src = '/sounds/game-start.mp3';
        newroom.volume = 0.4;
        newroom.play();
        $('.game-selector-item[data-room-name="double"]').removeClass('active');
        $('.game-selector-item[data-room-name="fast"]').addClass('active');
        $('#double').hide();
        $('#fast').show();
    });
    $('.game-selector-item[data-room-name="double"]').click(function (e) {
        var newroom = new Audio();
        newroom.src = '/sounds/game-start.mp3';
        newroom.volume = 0.4;
        newroom.play();
        $('.game-selector-item[data-room-name="fast"]').removeClass('active');
        $('.game-selector-item[data-room-name="double"]').addClass('active');
        $('#fast').hide();
        $('#double').show();
    });
    getinfodubl();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        statusCode: {
            500: function () {
                return;
            }
        }
    });

});

function getinfodubl() {
    var red = parseInt($('.bonus-game-bet-value-container:nth-child(1) .bonus-game-bet-value').html());
    var zero = parseInt($('.bonus-game-bet-value-container:nth-child(2) .bonus-game-bet-value').html());
    var black = parseInt($('.bonus-game-bet-value-container:nth-child(3) .bonus-game-bet-value').html());
    $('.game-selector-item[data-room-name="double"] .game-selector-item-info-prize').html(red + zero + black);
}

lastnumberdub = 0;

function chatdelet() {
    $(document).ready(function () {


        $('.admin_controls').click(function (e) {
            var it = $(this).attr("data-time");
            $.post('/chatdel', {messages: it}, function (data) {


                if (data) {
                    if (!data.success) {
                        noty({
                            text: '<div><div><strong>Ошибка</strong><br>' + data.errors + '</div></div>',
                            layout: 'topRight',
                            type: 'error',
                            theme: 'relax',
                            timeout: 8000,
                            closeWith: ['click'],
                            animation: {
                                open: 'animated flipInX',
                                close: 'animated flipOutX'
                            }
                        });
                    } else {
                        noty({
                            text: '<div><div><strong>Успешно</strong><br>' + data.success + '</div></div>',
                            layout: 'topRight',
                            type: 'success',
                            theme: 'relax',
                            timeout: 8000,
                            closeWith: ['click'],
                            animation: {
                                open: 'animated flipInX',
                                close: 'animated flipOutX'
                            }
                        });


                    }


                }
            });
        });

    });
}

function getRandomArbitary(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;

}

function showActivity(room, avatar, price) {
    var f = $('.game-selector-item[data-room-name="' + room + '"] .game-selector-item-new-trade');

    f.find(".game-selector-item-new-trade-avatar")
        .css({
            "background-image": 'url("' + avatar + '")'
        }), f.find(".game-selector-item-new-trade-sum")
        .text(price), f.addClass("game-selector-item-winner") , f.css({
        transition: "transform 0s, opacity 0s"
        , transform: "translate3d(0,0,0)"
        , opacity: 1
    }), //delay(function () {
        setTimeout(function () {
            f.css({
                transition: "transform 0.5s, opacity 0.5s"
                , transform: "translate3d(0,-15px,0)"
                , opacity: 0
            })
        }, 500);

    // }, 500)

    // var html = '<div class="game-selector-item-new-trade" style="transition: transform 0s, opacity 0s; transform: translate3d(0px, 0px, 0px); opacity: 1;"> ' +
    //   '<span class="game-selector-item-new-trade-avatar" style="background-image: url(' + avatar + ');"></span> ' +
    //  '<span>+</span> <span class="game-selector-item-new-trade-sum">' + price + '</span> </div>';
//    html.css({transition: "transform 0.5s, opacity 0.5s", transform: "translate3d(0,-15px,0)", opacity: 0});

}


function replaceLogin1(login) {
    var reg = new RegExp(BANNED_DOMAINS, 'i');
    return login.replace(reg, "");
}
function replaceLogin(login) {
    function replacer(match, p1, p2, p3, offset, string) {
        var links = ['cardup.one'];
        return links.indexOf(match.toLowerCase()) == -1 ? '' : match;
    }

    login = login.replace('сom', 'com').replace('cоm', 'com').replace('соm', 'com');
    var res = login.replace(/([а-яa-z0-9-]+) *\. *(ru|com|net|gl|su|red|ws|us|pro)+/gi, replacer);
    if (!res.trim()) {

        var check = login.toLowerCase().split('cardup.one').length > 1;

        if (check) {
            res = login;
        }
        else {
            res = login.replace(/csgo/i, '').replace(/ *\. *ru/i, '').replace(/ *\. *com/i, '');
            if (!res.trim()) {
                res = 'UNKNOWN';
            }
        }
    }

    res = res.split('script').join('srcipt');
    return res;
}

if (START) {
    var socket = io.connect(':7777', {'reconnection': true});
    socket
        .emit('chats')
        .on('connect', function () {
            $('#loader').hide();
        })
        .on('disconnect', function () {
            $('#loader').show();
        })
        .on('new.bet', function (data) {
            data = JSON.parse(data);
            $('.bonus-game-bet-value-container:nth-child(1) .bonus-game-bet-value-progress').css({"width": +data.red / data.all * 100 + '%'});
            $('.bonus-game-bet-value-container:nth-child(2) .bonus-game-bet-value-progress').css({"width": +data.zero / data.all * 100 + '%'});
            $('.bonus-game-bet-value-container:nth-child(3) .bonus-game-bet-value-progress').css({"width": +data.black / data.all * 100 + '%'});
            $('.bonus-game-bet-value-container:nth-child(1) .bonus-game-bet-value').html(data.red).css({transition: "width 500ms"});
            $('.bonus-game-bet-value-container:nth-child(2) .bonus-game-bet-value').html(data.zero).css({transition: "width 500ms"});
            $('.bonus-game-bet-value-container:nth-child(3) .bonus-game-bet-value').html(data.black).css({transition: "width 500ms"});
            //    $('.curr-game .parts-g .scroll').prepend(data.html) el.hide().fadeIn("slow");

            var el = $(data.html);
            el.hide();
            $('.curr-game .parts-g .scroll').prepend(el);
            el.fadeIn(1000);
            showActivity('double', el.find('img').attr("src"), el.find('.price').html());
            getinfodubl();

        })
        .on('online', function (data) {
            $('#online').text(Math.abs(data));
        })
        .on('slider', function (data) {

            if (ngtimerStatus) {
                $('.bonus-game-timer').css({transition: "600ms ease", transform: "rotateY(180deg)"});
                $('.bonus-game-pre-end').css({transition: "600ms ease", transform: "rotateY(360deg)"});
                ngtimerStatus = false;


                if (data.showSlider) {

                    setTimeout(function () {
                        var doubleGameRoulettenumber = {
                            0: [62, 83],
                            1: [38, 58],
                            2: [-6, 10],
                            3: [303, 323],
                            4: [255, 275],
                            5: [207, 227],
                            6: [159, 19],
                            7: [110, 130],
                            8: [15, 35],
                            9: [327, 347],
                            10: [-81, -60],
                            11: [231, 251],
                            12: [183, 203],
                            13: [135, 156],
                            14: [87, 107]
                        };

                        lastnumberdub = parseInt(doubleGameRoulettenumber[data.number][0]) + parseInt(getRandomArbitary(1, 20));
                        $('.game-roulette-numbers').attr('style', 'transition: transform ' + (data.time - 5) + 's; display: block; transform: rotate3d(0, 0, 1, ' + (parseInt(lastnumberdub) + 2160) + 'deg);');


                    }, 500);
                }
                var timeout = data.showSlider ? 6 : 0;
                setTimeout(function () {
                    var element = $('.bonus-game-end').first();
                    element.text(data.number);
                    element.removeClass('black');
                    element.removeClass('red');
                    element.removeClass('zero');
                    element.addClass(data.color);
                    element.css({transition: "600ms ease", transform: "rotateY(360deg)"});
                    $('.bonus-game-pre-end').css({transition: "600ms ease", transform: "rotateY(180deg)"});
                    $('.bonus-game-bet-value-container:nth-child(1) .bonus-game-bet-value-progress').css({"width": '0%'});
                    $('.bonus-game-bet-value-container:nth-child(2) .bonus-game-bet-value-progress').css({"width": '0%'});
                    $('.bonus-game-bet-value-container:nth-child(3) .bonus-game-bet-value-progress').css({"width": '0%'});

                    $('.bonus-game-bet-value-container.' + data.color + ' div:nth-child(1)').css({"width": '100%'});
                    var lastWinners = $('.stat')

                    var el = $(
                        "<li class='game-roulette-history-item " + data.color + "'>" +
                        "<form action='https://api.random.org/verify' method='post' target='_blank'>" +
                        "<input type='hidden' name='format' value='json'/>" +
                        "<input type='hidden' name='random' value='" + data.random + "'/>" +
                        "<input type='hidden' name='signature' value='" + data.signature + "'/><button type='submit' class='btn btn-white btn-sm btn-right'>" + data.number + "</button></form></li>"
                    )
                    lastWinners.prepend(el)
                    el.fadeIn(1000)
                    lastWinners.find(".game-roulette-history-item:nth-of-type(15)").remove();
                    var doubleGameRoulettenumber = {
                        0: [62, 83],
                        1: [38, 58],
                        2: [-6, 10],
                        3: [303, 323],
                        4: [255, 275],
                        5: [207, 227],
                        6: [159, 19],
                        7: [110, 130],
                        8: [15, 35],
                        9: [327, 347],
                        10: [-81, -60],
                        11: [231, 251],
                        12: [183, 203],
                        13: [135, 156],
                        14: [87, 107]
                    };
                    if (lastnumberdub > 0) {
                        $('.game-roulette-numbers').attr('style', 'display: block; transform: rotate3d(0, 0, 1, ' + parseInt(lastnumberdub) + 'deg);');
                    } else {

                        $('.game-roulette-numbers').attr('style', 'display: block; transform: rotate3d(0, 0, 1, ' + parseInt(doubleGameRoulettenumber[data.number][0]) + parseInt(getRandomArbitary(1, 20)) + 'deg);');

                    }
                    $.post('/getBalance', function (data) {
                        var win = parseInt(data) - parseInt($('.update_balance').text());
                        if (data > $('.update_balance').text()) {
                            noty({
                                text: '<div><div><strong>Ура</strong><br>Вы выиграли ' + win + '</div></div>',
                                layout: 'topRight',
                                type: 'success',
                                theme: 'relax',
                                timeout: 8000,
                                closeWith: ['click'],
                                animation: {
                                    open: 'animated flipInX',
                                    close: 'animated flipOutX'
                                }
                            });
                        }
                        $('.update_balance').text(data);
                    });

                }, 1000 * timeout);

            }
        })

        .on('newGame', function (data) {
            $.post('/getBalance', function (data) {
                $('.update_balance').text(data);
            });
            var element = $('.bonus-game-end').first();
            element.text(0);
            element.attr('style', 'transition: transform 2s;transform: rotateY(180deg);');
            element.removeClass('black');
            element.removeClass('red');
            element.removeClass('zero');
            $('.bonus-game-timer.front').attr('data-left-seconds', '40');
            $('.bonus-game-timer.front circle').attr('style', 'stroke-dashoffset:0;transition: stroke-dashoffset 1s linear');
            $('.bonus-game-pre-end').css({transition: "600ms ease", transform: "rotateY(180deg)"});
            $('.bonus-game-timer').css({transition: "600ms ease", transform: "rotateY(360deg)"});
            $('.curr-game .parts-g .scroll').html('');
            $('.bonus-game-bet-value-container:nth-child(1) .bonus-game-bet-value-progress').css({"width": '0%'});
            $('.bonus-game-bet-value-container:nth-child(2) .bonus-game-bet-value-progress').css({"width": '0%'});
            $('.bonus-game-bet-value-container:nth-child(3) .bonus-game-bet-value-progress').css({"width": '0%'});
            $('.bonus-game-bet-value-container:nth-child(1) .bonus-game-bet-value').html(0);
            $('.bonus-game-bet-value-container:nth-child(2) .bonus-game-bet-value').html(0);
            $('.bonus-game-bet-value-container:nth-child(3) .bonus-game-bet-value').html(0);
            timerStatus = true;
            ngtimerStatus = true;
            getinfodubl();
        })

        .on('timer', function (time) {
            if (timerStatus) {
                $('.bonus-game-end, .bonus-game-pre-end').css({transition: "600ms ease", transform: "rotateY(180deg)"});
                timerStatus = false;


                var counter = time;
                var id;

                id = setInterval(function () {
                    counter--;
                    if (counter < 0) {
                        clearInterval(id);
                    } else {
                        var tmlf = counter.toString();

                        if (tmlf < 10) {
                           var tmlf = 0 + tmlf;
                        }
                        $('.bonus-game-timer.front').first().attr('data-left-seconds', tmlf);
                        $('.bonus-game-timer-svg circle').attr('style', 'stroke-dashoffset:' + (-1) * (40 - counter.toString()) * (410 / 39) + ';transition: stroke-dashoffset 1s linear')
                    }
                }, 1000);


            }
        })
        .on('chatdel', function (data) {
            info = JSON.parse(data);
            $('#chatm_' + info.time2).remove();
        })
        .on('chat', function (data) {
            msg = JSON.parse(data);
            var chat = $('.chat .inbox');
            var messages = msg.messages;
            messages = messages.replace(":)", "<img style='background-position: 0px 0px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":-d", "<img style='background-position: 0px -17px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(";-)", "<img style='background-position: 0px -34px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("xd", "<img style='background-position: 0px -51px' id=smile src='/images/chat/white.gif'>");
            messages = messages.replace(";-p", "<img style='background-position: 0px -68px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":-p", "<img style='background-position: 0px -85px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("8-)", "<img style='background-position: 0px -102px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("b-)", "<img style='background-position: 0px -119px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":-(", "<img style='background-position: 0px -136px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(";-]", "<img style='background-position: 0px -153px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("u—(", "<img style='background-position: 0px -170px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":l(", "<img style='background-position: 0px -187px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":_(", "<img style='background-position: 0px -204px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":((", "<img style='background-position: 0px -221px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":o", "<img style='background-position: 0px -238px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":|", "<img style='background-position: 0px -255px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("3-)", "<img style='background-position: 0px -272px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("o*)", "<img style='background-position: 0px -323px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(";o", "<img style='background-position: 0px -340px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("8o", "<img style='background-position: 0px -374px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("8|", "<img style='background-position: 0px -357px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":x", "<img style='background-position: 0px -391px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("*3", "<img style='background-position: 0px -442px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":-*", "<img style='background-position: 0px -409px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace("}^)", "<img style='background-position: 0px -425px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(">((", "<img style='background-position: 0px -306px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(">(", "<img style='background-position: 0px -289px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":like:", "<img style='background-position: 0px -459px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":dislike:", "<img style='background-position: 0px -476px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":u:", "<img style='background-position: 0px -493px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":v:", "<img style='background-position: 0px -510px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":kk:", "<img style='background-position: 0px -527px' id=smile src=/images/chat/white.gif>");
            messages = messages.replace(":sm1:", "<img style='background:none;' id=smile src=/images/chat/D83DDC4F.png>");
            messages = messages.replace(":sm2:", "<img style='background:none;' id=smile src=/images/chat/D83DDC4A.png>");
            messages = messages.replace(":sm3:", "<img style='background:none;' id=smile src=/images/chat/270B.png>");
            messages = messages.replace(":sm4:", "<img style='background:none;' id=smile src=/images/chat/D83DDE4F.png>");
            messages = messages.replace(":sm5:", "<img style='background:none;' id=smile src=/images/chat/D83DDC43.png>");
            messages = messages.replace(":sm6:", "<img style='background:none;' id=smile src=/images/chat/D83DDC46.png>");
            messages = messages.replace(":sm7:", "<img style='background:none;' id=smile src=/images/chat/D83DDC47.png>");
            messages = messages.replace(":sm8:", "<img style='background:none;' id=smile src=/images/chat/D83DDC48.png>");
            messages = messages.replace(":sm9:", "<img style='background:none;' id=smile src=/images/chat/D83DDCAA.png>");
            messages = messages.replace(":sm10:", "<img style='background:none;' id=smile src=/images/chat/D83DDC42.png>");
            messages = messages.replace(":sm11:", "<img style='background:none;' id=smile src=/images/chat/D83DDC8B.png>");
            messages = messages.replace(":sm12:", "<img style='background:none;' id=smile src=/images/chat/D83DDCA9.png>");
            messages = messages.replace(":sm13:", "<img style='background:none;' id=smile src=/images/chat/2744.png>");
            messages = messages.replace(":sm14:", "<img style='background:none;' id=smile src=/images/chat/D83CDF77.png>");
            messages = messages.replace(":sm15:", "<img style='background:none;' id=smile src=/images/chat/D83CDF78.png>");
            messages = messages.replace(":sm16:", "<img style='background:none;' id=smile src=/images/chat/D83CDF85.png>");
            messages = messages.replace(":sm17:", "<img style='background:none;' id=smile src=/images/chat/D83DDCA6.png>");
            messages = messages.replace(":sm18:", "<img style='background:none;' id=smile src=/images/chat/D83DDC7A.png>");
            messages = messages.replace(":sm19:", "<img style='background:none;' id=smile src=/images/chat/D83DDC28.png>");
            messages = messages.replace(":sm20:", "<img style='background:none;' id=smile src=/images/chat/D83CDF4C.png>");
            messages = messages.replace(":sm21:", "<img style='background:none;' id=smile src=/images/chat/D83CDFC6.png>");
            messages = messages.replace(":sm22:", "<img style='background:none;' id=smile src=/images/chat/D83CDFB2.png>");
            messages = messages.replace(":sm23:", "<img style='background:none;' id=smile src=/images/chat/D83CDF7A.png>");
            messages = messages.replace(":sm24:", "<img style='background:none;' id=smile src=/images/chat/D83CDF7B.png>");
            var urls = '/user/' + msg.userid;
            if (msg.admin || msg.support) {
                var urls = '#';
            }
            var style = '';
            if (!admin) {
                var style = 'style="display:none"';
            }
            chat.find('.chat-messages').prepend(
                '  <div class="short" id="chatm_' + msg.time2 + '">' +
                '<div class="top">' +
                '<div class="avatar"><a onClick="Page.Go(this.href); return false;" href="' + urls + '"><img src="' + msg.avatar + '" alt=""></a></div>' +
                '<a href="#" onclick="var u = $(this); $(\'#chatInput\').val(u.text() + \', \'); return false;" class="name">' + replaceLogin(msg.username) + '</a>' +
                '<div class="date">' + msg.time + ' <a class="admin_controls" ' + style + ' data-time="' + msg.time2 + '"  data-chat="' + msg.messages + '" data-chat-username="' + msg.username + '">[x]</a></div>' +
                '</div>' +
                '<div class="message">' + messages + '</div>' +
                '</div>');
            chatdelet();
            var height = $('.chat-messages').height();
        })
    var declineTimeout,
        timerStatus = true,
        ngtimerStatus = true;
}


$(document).ready(function () {


    $(document).on('click', ".box-modal#settings-m .info input[type='submit']", function (e) {
        var that = $(".box-modal#settings-m .input input[type='text']");
        $.post('/save_link', {trade_link: that.val()}, function (data) {

            if (data.status == 'success') {

                noty({
                    text: '<div><div><strong>Ссылка успешно сохранена</strong><br>Не забудьте открыть инвентарь чтобы получить выигрыш!</div></div>',
                    layout: 'topRight',
                    type: 'success',
                    theme: 'relax',
                    timeout: 8000,
                    closeWith: ['click'],
                    animation: {
                        open: 'animated flipInX',
                        close: 'animated flipOutX'
                    }
                });
            }
            else {
                noty({
                    text: '<div><div><strong>Ошибка</strong><br>Введите нормальную ссылку и попробуйте ещё раз</div></div>',
                    layout: 'topRight',
                    type: 'error',
                    theme: 'relax',
                    timeout: 8000,
                    closeWith: ['click'],
                    animation: {
                        open: 'animated flipInX',
                        close: 'animated flipOutX'
                    }
                });
            }

        });


    });


    $('#chatInput').bind("enterKey", function (e) {
        var input = $(this);
        var msg = input.val();
        if (msg != '') {
            $.post('/chat', {messages: msg}, function (data) {
                if (data) {
                    if (!data.success) {
                        noty({
                            text: '<div><div><strong>Ошибка</strong><br>' + data.errors + '</div></div>',
                            layout: 'topRight',
                            type: 'error',
                            theme: 'relax',
                            timeout: 8000,
                            closeWith: ['click'],
                            animation: {
                                open: 'animated flipInX',
                                close: 'animated flipOutX'
                            }
                        });
                    } else {
                        noty({
                            text: '<div><div><strong>Успешно</strong><br>' + data.success + '</div></div>',
                            layout: 'topRight',
                            type: 'success',
                            theme: 'relax',
                            timeout: 8000,
                            closeWith: ['click'],
                            animation: {
                                open: 'animated flipInX',
                                close: 'animated flipOutX'
                            }
                        });
                        input.val('');
                    }

                }
                else
                    input.val('');
            });
        }
    });
    $('#chatInput').keyup(function (e) {
        if (e.keyCode == 13) {
            $(this).trigger("enterKey");
        }
    });
    $('#chatInput2').on('click', function (event) {
        $('#chatInput').trigger("enterKey");
    });

    $('.bonus-game-calc-place-bet').click(function () {
        var operation = $(this).attr('data-bet-type');
        var sum = $('#dub-input').val();
        $.post('/newbet', {operation: operation, sum: sum}, function (data) {

            if (data.status == 'error_game') {
                noty({
                    text: '<div><div><strong>Ошибка</strong><br>' + data.msg + '</div></div>',
                    layout: 'topRight',
                    type: 'error',
                    theme: 'relax',
                    timeout: 8000,
                    closeWith: ['click'],
                    animation: {
                        open: 'animated flipInX',
                        close: 'animated flipOutX'
                    }
                });


            }
            if (data.status == 'error_steam') {
                noty({
                    text: '<div><div><strong>Ошибка</strong><br>' + data.msg + '</div></div>',
                    layout: 'topRight',
                    type: 'error',
                    theme: 'relax',
                    timeout: 8000,
                    closeWith: ['click'],
                    animation: {
                        open: 'animated flipInX',
                        close: 'animated flipOutX'
                    }
                });

            }
            $.post('/getBalance', function (data) {
                $('.update_balance').text(data);
            });
        });
    });
    $('.bonus-game-calc-button').click(function () {
        var operation = $(this).attr('data-method');
        var betField = $('#dub-input');
        var repeat = $('.bonus-game-calc-button .repeat-bet').attr('data-value');
        var sum = $(this).attr('data-value');
        if (betField.val() == '') {
            betField.val(0);
        }
        switch (operation) {
            case "repeat-bet":
                betField.val(parseInt(repeat));
                break;
            case "clear":
                $('.bonus-game-calc-button .repeat-bet').attr('data-value', betField.val());
                betField.val(0);
                break;
            case "plus":
                betField.val(parseInt(betField.val()) + parseInt(sum));
                break;
            case "multiply":
                betField.val(parseInt(betField.val()) * 2);
                break;
            case "divide":
                betField.val(parseInt(betField.val()) / 2);
                break;
            case "max":
                betField.val(parseInt($(".update_balance").html()));
                break;
        }
    });
});
