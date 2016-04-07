@extends('layout')

@section('content')


    <div class="content">
        <div class="roulette" style="display:none">
            <div class="inbox"></div>
        </div>

        <div class="not-g warning last_deposits" style="display:none"><span>Game is ending! Last deposits from the queue is near accepting</span>
        </div>
        <div class="not-g success queue" style="display: none;">
            <span>Your deposit is in queue. Average waiting time &mdash; 3-4 seconds</span></div>

        <ul class="game-selector">
            <li data-room-name="fast" class="game-selector-item">
                <div class="game-selector-item-header">Быстрая игра<span class="beta">Alpha</span></div>
                <div class="game-selector-item-info-container">
                    <div class="game-selector-item-new-trade"><span class="game-selector-item-new-trade-avatar"></span>
                        <span>+</span> <span class="game-selector-item-new-trade-sum">0$</span></div>
                    <span>На кону:</span> <span class="game-selector-item-info-prize">0 руб.</span></div>
            </li>
            <li data-room-name="double" class="game-selector-item active">
                <div class="game-selector-item-header">Дабл<span class="beta">Beta</span></div>
                <div class="game-selector-item-info-container">
                    <div class="game-selector-item-new-trade"
                         style="transition: transform 0.5s, opacity 0.5s; transform: translate3d(0px, -15px, 0px); opacity: 0;">
                        <span class="game-selector-item-new-trade-avatar"></span> <span>+</span> <span
                                class="game-selector-item-new-trade-sum">1500</span></div>
                    <span class="game-selector-item-info-state">На кону:</span> <span
                            class="game-selector-item-info-prize">{{$red+$zero+$black}}</span></div>
            </li>
        </ul>
        <div class="curr-game">
            <div id="fast" style="display: none">

                @include('pages.fast')
            </div>

            <div id="double">
                <div class="parts-g">
                    <div class="scroll">
                        @foreach($bets as $bet)
                            @include('includes.bet')
                        @endforeach
                    </div>
                </div>

                <div class="bonus-game-roulette bonus-room">


                    <div class="game-roulette-numbers"
                         style="transition: transform 0s; display: block;transform: rotate3d(0, 0, 1, 48deg);"></div>
                    <div class="bonus-game-state-container" style="transition: 0ms ease; transform: rotateY(0deg);">
                        <div class="bonus-game-state bonus-game-timer front" data-left-seconds="40"
                             style="display: block;">
                            <svg class="bonus-game-timer-svg" width="200" height="200" viewport="0 0 100 100"
                                 version="1.1"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle r="65" cx="100" cy="100" stroke-dasharray="565.48" stroke-dashoffset="0"
                                        style="stroke-dashoffset:0;transition: stroke-dashoffset 1s linear"></circle>
                            </svg>
                        </div>
                        <div class="bonus-game-state bonus-game-pre-end back"
                             style="transition: transform 2s; transform: rotateY(180deg)">Розыгрыш
                        </div>
                        <div class="bonus-game-state bonus-game-end back"
                             style="transition: transform 2s;transform: rotateY(180deg);">1
                        </div>
                    </div>
                    <div class="sprite game-roulette-cursor"></div>
                    <div class="sprite game-roulette-cursor-shadow"></div>


                    <div class="game-roulette-history">
                        <ul class="game-roulette-history-list">
                            <div class="stat">
                                @foreach($games as $i)
                                    <li class="game-roulette-history-item {{$i->color}}">
                                        <form action='https://api.random.org/verify' method='post' target="_blank">
                                            <input type='hidden' name='format' value='json'/>
                                            <input type='hidden' name='random' value='{{$i->random}}'/>
                                            <input type='hidden' name='signature' value='{{$i->signature}}'/>
                                            <button type="submit"
                                                    class="btn btn-white btn-sm btn-right">{{$i->number}}</button>
                                        </form>
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                    </div>
                </div>

                <div class="items-g">
                    <div class="scroll items_in_game ">
                        <div class="bonus-game-bet-calc game bonus-room">
                            <div>

                                <div class="bonus-game-calc">
                                    <ul class="bonus-game-calc-button-list">
                                        <li class="bonus-game-calc-button repeat-bet" data-method="repeat-bet"><span
                                                    class="sprite repeat-bet" data-value="0"></span></li>
                                        <li class="bonus-game-calc-button clear" data-method="clear"><span
                                                    class="sprite clear"></span></li>
                                        <li class="bonus-game-calc-button value" data-value="10" data-method="plus">
                                            +10
                                        </li>
                                        <li class="bonus-game-calc-button value" data-value="100" data-method="plus">
                                            +100
                                        </li>
                                        <li class="bonus-game-calc-button value" data-value="1000" data-method="plus">
                                            +1K
                                        </li>
                                        <li class="bonus-game-calc-button value" data-value="10000" data-method="plus">
                                            +10K
                                        </li>
                                        <li class="bonus-game-calc-button value" data-value="2" data-method="multiply">
                                            x2
                                        </li>
                                        <li class="bonus-game-calc-button value" data-value="2" data-method="divide">1/2
                                        </li>
                                        <li class="bonus-game-calc-button all" data-method="max">Все</li>
                                    </ul>
                                    <div class="bonus-game-bet-input-container"><input class="bonus-game-bet-input" id="dub-input" value="" placeholder="Введите сумму...">
                                    </div>
                                    <div class="bonus-game-calc-place-bet-buttons"><p class="place-bet-buttons-text">
                                            @if(!Auth::guest())Баланс : <span
                                                    class="update_balance">{{$u->money}}</span>@endif</p>
                                        <ul class="place-bet-buttons noselect">
                                            <li data-bet-type="red"
                                                class="bonus-game-calc-place-bet sprite bonus-red-button noselect">0
                                            </li>
                                            <li data-bet-type="zero"
                                                class="bonus-game-calc-place-bet sprite bonus-zero-button noselect">0
                                            </li>
                                            <li data-bet-type="black"
                                                class="bonus-game-calc-place-bet sprite bonus-black-button noselect">0
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="bonus-game-bet-info"><p>Общая ставка:</p>
                                    <ul class="bonus-game-bet-values">
                                        <li data-bet-type="red" class="bonus-game-bet-value-container red">
                                            <div class="bonus-game-bet-value-progress"
                                                 style="width: {{$red == 0 ? 0 : $red/($red+$zero+$black)*100}}%; transition: width 500ms;"></div>
                                            <div class="bonus-game-bet-value black">{{$red}}</div>
                                        </li>
                                        <li data-bet-type="zero" class="bonus-game-bet-value-container zero">
                                            <div class="bonus-game-bet-value-progress"
                                                 style="width: {{$zero == 0 ? 0 : $zero/($red+$zero+$black)*100}}%; transition: width 500ms;"></div>
                                            <div class="bonus-game-bet-value zero">{{$zero}}</div>
                                        </li>
                                        <li data-bet-type="black" class="bonus-game-bet-value-container black">
                                            <div class="bonus-game-bet-value-progress"
                                                 style="width: {{$black == 0 ? 0 : $black/($red+$zero+$black)*100}}%; transition: width 500ms;"></div>
                                            <div class="bonus-game-bet-value black">{{$black}}</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


@endsection