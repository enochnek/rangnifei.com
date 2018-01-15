@inject('injecter', 'App\Repositories\ConductionRepository')

        <div class="dropdown finfo dim">
            <div class="main vertpd-md inner-links">
                <div class="col-9">
                    <ul class="subw">
                        @foreach($injecter->getcGames() as $game)
                            <li><a href="javascript:;" class="img-sm" data-game="{{ $game->game_name }}" data-gameid="{{ $game->id }}"><img src="{{ $game->game_iconurl }}"> {{ $game->game_name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>