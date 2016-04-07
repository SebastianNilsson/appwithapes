<html>
<head>
    <meta charset="utf-8">
    <title>FASTLOOT.ME</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
    <link rel="stylesheet" id="main-style" href="{{ asset('styles/styles.css')}}"/>
    <link rel="stylesheet" href="{{ asset('styles/fonts.css')}}"/>
    <link rel="stylesheet" href="{{ asset('styles/jquery.arcticmodal-0.3.css')}}"/>
    <link rel="stylesheet" href="{{ asset('styles/tooltipster.css')}}"/>
    <link rel="stylesheet" href="{{ asset('noty/core.css')}}"/>
    <link rel="stylesheet" href="{{ asset('noty/animate.css')}}"/>
    <script src="{{ asset('scripts/jquery-1.7.2.js')}}"></script>
    <script src="{{ asset('scripts/tabs.js')}}"></script>
    <script src="{{ asset('scripts/jquery.arcticmodal-0.3.min.js')}}"></script>
    <script src="{{ asset('scripts/jquery.tooltipster.min.js')}}"></script>
    <script src="{{ asset('scripts/jquery.noty.js')}}"></script>
    <script src="{{ asset('scripts/socket.io.js')}}"></script>
    <meta name="csrf-token" content="{!!  csrf_token()   !!}">
    <script>var START = true;
                @if(Auth::user()) const admin = '{{$u->is_admin}}';  @endif</script>
    <script src="{{ asset('scripts/app.js')}}"></script>
</head>
<body>

<header>

    <div class="top">
        <div class="width">
            <a href="/" class="logotype"></a>

            <ul class="menu">
                <li><a href="/">Играть</a></li>
                <li><a href="/shop">Магазин</a></li>
                <li><a href="/about">О сайте</a></li>
                <li><a href="#" onclick="$('#partner-m').arcticmodal()">Партнёрка</a></li>
                <li><a href="#" onclick="$('#fairplay-m').arcticmodal()">Честная игра</a></li>
            </ul>


            @if(Auth::guest())
                <a href="/login" class="login">Войти через Steam</a>
            @else
                <div class="profile">
                    <img src="{{$u->avatar}}" alt="" title="">
                    <div class="name">{{$u->username}}</div>
                    <div class="sub">
                        <ul>
                            <li><a href="#" data-load-user="76561198175661250">Мой профиль</a></li>
                            <li><a href="#" onclick="$('#settings-m').arcticmodal()">Настройки</a></li>
                            <li><a href="/logout">Выйти</a></li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="not steam">
        <span>Вывод коинов :</span> <a href="#">Коины можно вывести в магазине</a>

    </div>
</header>
</br>
    @yield('content')
    <footer>
        <a href="#" class="facebook"></a>
        <a href="#" class="steam"></a>
        <div class="mail">admin@scripter.su</div>
    </footer>

    <div class="chat">
        <div class="chat-header">Чат <span>Онлайн: <span
                        id="online">{{\App\Http\Controllers\ChatController::online()}}</span></span></div>
        <div class="chat-container" style="height: 0;">

            <div class="inbox">
                <div class="scroll chat-messages">
                    {{--*/ $messages = \App\Http\Controllers\ChatController::chat(); /*--}}
                    @if($messages != 0)
                        @foreach($messages as $sms)
                            <div class="short" id="chatm_{{$sms['time2']}}">
                                <div class="top">
                                    <div class="avatar">
                                        <a onClick="Page.Go(this.href); return false;"
                                           href="@if($sms['admin'] || $sms['support'])#@else/user/{{$sms['userid']}}@endif">
                                            <img src="{{$sms['avatar']}}"
                                                 alt=""></a></div>

                                    <a class="name" href="#"
                                       @if($sms['admin'])style="color: #FF5151;text-shadow: 1px 1px 1px rgba(113, 19, 19, 0.04), 0 0 3px #4E0000;"
                                       @endif
                                       onclick="var u = $(this); $('#chatInput').val(u.text() + ', '); return false;">{{$sms['username']}}</a>

                                    <div class="date">{{$sms['time']}} @if(Auth::user() and $u->is_admin) <a
                                                class="admin_controls" data-chat="{!!$sms['messages']!!}"
                                                data-time="{{$sms['time2']}}" data-chat-username="{{$sms['username']}}">[x]</a>@endif
                                    </div>
                                </div>
                                <div class="message">{!!$sms['messages']!!}
                                </div>
                            </div>

                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form chat-form">
                <textarea maxlength="100" id="chatInput" placeholder="Набирите сообщение..."></textarea>
                <div class="right">
                    <div class="smiles">
                        <div class="sub">
                            <img src="/images/chat/white.gif" style="background-position: 0px 0px" id="smile"
                                 onclick="add_smile(':)')">
                            <img src="/images/chat/white.gif" style="background-position: 0px -17px" id="smile"
                                 onclick="add_smile(':-d')">
                            <img src="/images/chat/white.gif" style="background-position: 0px -34px" id="smile"
                                 onclick="add_smile(';-)')">
                            <img src="/images/chat/white.gif" style="background-position: 0px -51px" id="smile"
                                 onclick="add_smile('xd')">
                            <img src="/images/chat/white.gif" style="background-position: 0px -68px" id="smile"
                                 onclick="add_smile(';-p')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -85px" id="smile"
                                 onclick="add_smile(':-p')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -102px" id="smile"
                                 onclick="add_smile('8-)')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -119px" id="smile"
                                 onclick="add_smile('b-)')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -136px" id="smile"
                                 onclick="add_smile(':-(')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -153px" id="smile"
                                 onclick="add_smile(';-]')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -170px" id="smile"
                                 onclick="add_smile('u—(')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -187px" id="smile"
                                 onclick="add_smile(':l(')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -204px" id="smile"
                                 onclick="add_smile(':_(')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -221px" id="smile"
                                 onclick="add_smile(':((')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -238px" id="smile"
                                 onclick="add_smile(':o')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -255px" id="smile"
                                 onclick="add_smile(':|')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -272px" id="smile"
                                 onclick="add_smile('3-)')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -323px" id="smile"
                                 onclick="add_smile('o*)')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -340px" id="smile"
                                 onclick="add_smile(';o')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -374px" id="smile"
                                 onclick="add_smile('8o')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -357px" id="smile"
                                 onclick="add_smile('8|')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -391px" id="smile"
                                 onclick="add_smile(':x')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -442px" id="smile"
                                 onclick="add_smile('*3')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -409px" id="smile"
                                 onclick="add_smile(':-*')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -425px" id="smile"
                                 onclick="add_smile('}^)')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -306px" id="smile"
                                 onclick="add_smile('>((')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -289px" id="smile"
                                 onclick="add_smile('>(')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -459px" id="smile"
                                 onclick="add_smile(':like:')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -476px" id="smile"
                                 onclick="add_smile(':dislike:')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -493px" id="smile"
                                 onclick="add_smile(':u:')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -510px" id="smile"
                                 onclick="add_smile(':v:')">


                            <img src="/images/chat/white.gif" style="background-position: 0px -527px" id="smile"
                                 onclick="add_smile(':kk:')">


                            <img src="/images/chat/D83DDC4F.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm1:')">

                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDC4A.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm2:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/270B.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm3:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDE4F.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm4:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDC43.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm5:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDC46.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm6:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDC47.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm7:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDC48.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm8:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDCAA.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm9:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDC42.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm10:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDC8B.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm11:')">

                            <!-- смайлы конец -->
                            <!-- смайл начало -->

                            <img src="/images/chat/D83DDCA9.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm12:')">
                            <img src="/images/chat/2744.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm13:')">

                            <img src="/images/chat/D83CDF77.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm14:')">
                            <img src="/images/chat/D83CDF78.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm15:')">
                            <img src="/images/chat/D83CDF85.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm16:')">
                            <img src="/images/chat/D83DDCA6.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm17:')">
                            <img src="/images/chat/D83DDC7A.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm18:')">
                            <img src="/images/chat/D83DDC28.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm19:')">
                            <img src="/images/chat/D83CDF4C.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm20:')">
                            <img src="/images/chat/D83CDFC6.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm21:')">
                            <img src="/images/chat/D83CDFB2.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm22:')">
                            <img src="/images/chat/D83CDF7A.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm23:')">
                            <img src="/images/chat/D83CDF7B.png" id="smile" style="background:none;"
                                 onclick="add_smile(':sm24:')">
                        </div>
                        <span></span>
                    </div>
                    <input type="submit" class="btn" id="chatInput2" value="OK">
                </div>
            </div>
        </div>

        <script>
            $('.chat-header').click(function () {
                if ($('.chat-container').height() < 392) {
                    chat_height = 392;
                } else {
                    chat_height = 0;
                }
                $('.chat-container').animate({
                    height: chat_height + 'px'
                }, 100);
            });
        </script>

        <div style="display: none;">
            <div class="box-modal" id="fairplay-m">

                <div class="title">Честная игра
                    <div class="box-modal_close arcticmodal-close"></div>
                </div>

                <div class="text">
                    <div style="margin-bottom: 20px;"> В начале каждого раунда сервис генерирует случайное длинное число
                        от 0 до
                        1 (например, 0.223088) и шифрует его через алгоритм <a
                                href="https://ru.wikipedia.org/wiki/SHA-2"
                                target="_blank">sha224</a>. Результат шифрования
                        виден в начале раунда. В конце раунда сервис умножает зашифрованное ранее число на 15, получая
                        номер
                        победного сектора.<br><br> <span style="font-style: italic">Пример: В начале раунда было зашифровано число 0.223088232334703230728. Сервис умножает число 0.223088232334703230728 на 15 и получает число 3,34632348495. Целым числом результата умножения получилось число 3 (красный сектор). В данном раунде победят игроки, которые делали ставки на победу красного сектора</span><br><br>
                        Вы можете самостоятельно проверить правильность определения победного сектора. Для этого в конце
                        раунда
                        возьмите число, которое было зашифровано и повторно закодируйте его с помощью любого из онлайн
                        сервисов,
                        например <a href="http://www.miniwebtool.com/sha224-hash-generator/" target="_blank">http://www.miniwebtool.com/sha224-hash-generator/</a>.
                        Вы увидите то же значение hash, что и в начале раунда. Это означает что результат игры не был
                        подстроен.<br><br>
                        <b>Поскольку система определяет победный сектор ещё до начала игры и любой игрок может
                            проконтролировать
                            отсутствие его изменений - вмешательство в игру для нас теряет смысл. Поэтому эта система
                            является
                            гарантом честности наших игр.</b></div>
                </div>
                <div class="form">
                    <input type="text" id="roundHash" name="" placeholder="Round hash">
                    <input type="text" id="roundNumber" name="" placeholder="Round number">
                    <input type="text" id="roundPrice" name="" placeholder="Game bank (in $)">
                    <input type="submit" id="checkHash" name="" value="Check">
                    <div class="result" id="checkResult"></div>
                </div>
            </div>

            <script src="{{ asset('scripts/md5-min.js')}}"></script>

            <script>
                $(document).on('click', '#checkHash', function () {
                    var hash = $('#roundHash').val();
                    var number = $('#roundNumber').val() || '';
                    var bank = $('#roundPrice').val() || 0;
                    var result = $('#checkResult');

                    if (hex_md5(number) == hash) {
                        var n = Math.round(+bank * 100 * +number);
                        result.html(n);
                    } else {
                        result.html('Hashes mistmatch');
                    }
                });
            </script>
        </div>
        @if(!Auth::guest())
            <div style="display: none;">
                <div class="box-modal" id="settings-m">
                    <div class="title">Настройки профиля
                        <div class="box-modal_close arcticmodal-close"></div>
                    </div>

                    <div class="text">
                        <div class="left">Ваша ссылка на обмен</div>
                        <div class="right"><a
                                    href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url"
                                    target="_blank">Искать здесь?</a></div>
                    </div>
                    <div class="input"><input type="text" name="url" value="{{$u->trade_link}}" autocomplete="off"
                                              placeholder="https://steamcommunity.com/tradeoffer/new/?partner=177156307&token=N_QiYSnb">
                    </div>
                    <div class="info">
                        <div class="left">ПРОВЕРЬТЕ ОБМЕНЫ НА ВАШЕМ АККАУНТЕ STEAM</div>
                        <input type="submit" name="" value="Сохранить">
                    </div>
                </div>
            </div>
            <div style="display: none;">
                <div class="box-modal" id="partner-m">
                    <div class="title">Партнёрка
                        <div class="box-modal_close arcticmodal-close"></div>
                    </div>

                    <div class="text">
                        <div class="left">Ваша код</div>
                    </div>
                    <div class="input"><input type="text" name="url" value="test" readonly>
                    </div>
                    <div class="info">
                        <div class="left">Когда кто-то переходит по вашей ссылке и регистрируется, он становится рефералом, так же, как если бы он ввёл ваш код</div>.
                    </div>
                </div>
            </div>
@endif
</body>
</html>