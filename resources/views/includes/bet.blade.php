<div class="short" id="ch_{{$bet->id}}">
    <img src="{{$bet->user->avatar}}"
         alt="" title="">



    <div class="text"><a href="#" data-load-user="{{$bet->user->steamid64}}">{{$bet->user->username}}</a>
        поставил   <span class="price">{{$bet->sum}}</span> {{ trans_choice('lang.coin', $bet->sum) }}
        на
        <span>{{ trans('lang.color.' . $bet->color) }}</span></div>
</div>