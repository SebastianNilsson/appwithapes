var auth = require('http-auth'),
    scribe = require('scribe-js')(),
    console = process.console,
    config = require('./config.js'),
    app = require('express')(),
    server = require('http').Server(app),
    io = require('socket.io')(server),
    redis = require('redis'),
    requestify = require('requestify'),
    fs = require('fs');
//bot = require('./bot.js');
var redisClient = redis.createClient(),
    client = redis.createClient();

//bot.init(redis, io, requestify);
server.listen(7777);

var basicAuth = auth.basic({ //basic auth config
    realm: "EZYSKINS.ru WebPanel",
    file: __dirname + "/users.htpasswd" // test:test
});
app.use('/logs', auth.connect(basicAuth), scribe.webPanel());
redisClient.subscribe('bets.list');
redisClient.subscribe('new.bet');
redisClient.subscribe('new.msg');
redisClient.subscribe('del.msg');
redisClient.setMaxListeners(0);
redisClient.on("message", function (channel, message) {
    if (channel == 'new.bet') {
        io.sockets.emit(channel, message);
    }
    if (channel == 'new.msg') {
        io.sockets.emit('chat', message);
    }
    if (channel == 'del.msg') {
        io.sockets.emit('chatdel', message);
    }
});

io.sockets.on('connection', function (socket) {

    updateOnline();


    socket.on('disconnect', function () {

        updateOnline();
    })
});


function updateOnline() {
    var online = Object.keys(io.sockets.adapter.rooms).length;
    client.set("online", online, redis.print);
    io.sockets.emit('online', online);
    console.info('Онлайн ' + online);
}


var checkNewBet = function () {
    requestify.get('http://' + config.domain + '/api/newBet', {
            secretKey: config.secretKey
        })
        .then(function (response) {

            var answer = JSON.parse(response.body);
            console.log(answer);
        }, function (response) {
            console.tag('SteamBot').error('Something wrong with send a new bet. Retry...');
            setTimeout(function () {
              checkNewBet()
            }, 1000);
        });
}


var game,
    timer,
    ngtimer,
    timerStatus = false,
    timerTime = 40, // время
    preFinishingTime = 1;
getCurrentGame();
var preFinish = false;
function startTimer() {
    var time = timerTime;
    timerStatus = true;
    clearInterval(timer);
    console.tag('Game').log('Game start.');
    timer = setInterval(function () {
        console.tag('Game').log('Timer:' + time);
        io.sockets.emit('timer', time--);
        if ((game.status == 0) && (time <= preFinishingTime)) {
            if (!preFinish) {
                preFinish = true;
                setGameStatus(1); // ставим статус 1
            }
        }
        if (time <= 0) {
            clearInterval(timer);
            timerStatus = false;
            console.tag('Game').log('Game end.');
            showSliderWinners();// тут заканчиваем и показываем рулетку
        }
    }, 1000);
}


function newGame() {
    requestify.post('http://' + config.domain + '/api/newGame', {
            secretKey: config.secretKey
        })
        .then(function (response) {
            preFinish = false;
            game = JSON.parse(response.body);
            console.tag('Game').log('New game! #' + game.id);
            io.sockets.emit('newGame', game);
            startTimer();
            checkNewBet();
        }, function (response) {
            console.tag('Game').error('Something wrong [newGame]');
            setTimeout(newGame, 1000);
        });
}

function startNGTimer(winners) {
    var time = 10;
    data = JSON.parse(winners);
    data.showSlider = true;
    clearInterval(ngtimer);
    ngtimer = setInterval(function () {
        data = JSON.parse(winners);
        data.showSlider = true;
        if (time <= 5) data.showSlider = false;

        console.tag('Game').log('NewGame Timer:' + time);
        data.time = time--;
        io.sockets.emit('slider', data);
        if (time <= 0) {
            clearInterval(ngtimer);
            newGame();
        }
    }, 1000);
}


function showSliderWinners() {
    requestify.post('http://' + config.domain + '/api/getWinners', {
            secretKey: config.secretKey
        })
        .then(function (response) {
            var winners = response.body;
            console.tag('Game').log('Show slider!');
            startNGTimer(winners);
            setGameStatus(2);
            //io.sockets.emit('slider', winners)
        }, function (response) {
            console.tag('Game').error('Something wrong [showSlider]');
            setTimeout(showSliderWinners, 1000);
        });
}


function setGameStatus(status) {
    requestify.post('http://' + config.domain + '/api/setGameStatus', {
            status: status,
            secretKey: config.secretKey
        })
        .then(function (response) {
            game = JSON.parse(response.body);
            console.tag('Game').log('Set game to a prefinishing status. Bets are redirected to a new game.');
        }, function (response) {
            console.tag('Game').error('Something wrong [setGameStatus]');
            setTimeout(setGameStatus, 1000);
        });
}


function getCurrentGame() {
    requestify.post('http://' + config.domain + '/api/getCurrentGame', {
            secretKey: config.secretKey
        })
        .then(function (response) {
            game = JSON.parse(response.body);
            console.tag('Game').log('Current Game #' + game.id);
            if (game.status == 0) startTimer();
            if (game.status == 1) startTimer();
            if (game.status == 2) newGame();
        }, function (response) {
            console.tag('Game').log('Something wrong [getCurrentGame]');
            setTimeout(getCurrentGame, 1000);
        });
}
