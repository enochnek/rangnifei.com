@inject('injecter', 'App\Repositories\ConductionRepository')
<div class="vert-bg" style="background-image: url({{ $navbar[0]->banner_coverurl }});" data-info>
    <a href="{{ $navbar[0]->banner_weburl }}" class="attacher-rb hinfo">{{ $navbar[0]->banner_title }}</a>
</div>

<div class="depth-11 dim">
    <div class="main inner-links">
        <ul class="sub vertmg-sm inner-links">
            <li><a href="{{ url('/') }}" class="md" data-dropdown="hover"><i class="fa fa-th img-sm"></i> 所有游戏</a>
                <div class="dropdown finfo">
                    <div class="main vertpd-md">
                        <div class="col-9">
                            <ul class="subw">

        @foreach($injecter->getcGames() as $game)
            @if($game->game_group == 1 || $game->game_group == 0)
            <li><a href="{{ url('/game/'.$game->id) }}" class="img-sm" data-gameid="{{ $game->id }}">
                    <img src="{{ $game->game_iconurl }}"> {{ $game->game_name }}
                    @if(strlen($game->game_description) > 1)
                        <br> <span class="tn grey2">{{ $game->game_description }}</span>
                        @endif
                </a>
            </li>
                                    @endif
    @endforeach
    </ul>
                            <i class="hr" style="border-color: #777;"></i>
                            <ul class="subw">

                                @foreach($injecter->getcGames() as $game)
                                    @if($game->game_group == 2)
                                        <li><a href="{{ url('/game/'.$game->id) }}" class="img-sm" data-gameid="{{ $game->id }}">
                                                <img src="{{ $game->game_iconurl }}"> {{ $game->game_name }}
                                                @if(strlen($game->game_description) > 1)
                                                    <br> <span class="tn grey2">{{ $game->game_description }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <i class="hr" style="border-color: #777;"></i>
                            <ul class="subw">

                                @foreach($injecter->getcGames() as $game)
                                    @if($game->game_group == 3)
                                        <li><a href="{{ url('/game/'.$game->id) }}" class="img-sm" data-gameid="{{ $game->id }}">
                                                <img src="{{ $game->game_iconurl }}"> {{ $game->game_name }}
                                                @if(strlen($game->game_description) > 1)
                                                    <br> <span class="tn grey2">{{ $game->game_description }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

    </div>
    <div class="col-3">
        <ul class="subf offset-hori">

        </ul>
    </div>
    </div>
    </div>
    </li>
    @for ($i = 0; $i < 5; $i++)
        <li><a href="{{ url('/game/'.$games[$i]->id) }}" class="md"><img src="{{ $games[$i]->game_iconurl }}" class="img-sm"> {{ $games[$i]->game_name }}</a></li>
        @endfor
        </ul>
        <div class="fright vertmg-sm">
            <form class="input depth-11" action="/itemSearch" >
                <input type="text" class="" name="searchContent" placeholder="请输入搜索内容...">
                <button type="submit" class="fa fa-search square bg"></button>
            </form>
        </div>
    </div>
</div>