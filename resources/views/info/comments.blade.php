@if (count($comments))
    @foreach($comments as $comment)
    <div class="padding-md">
        <div class="fleft padding-md offset-head">
            <img src="{{ $comment->user->avatar }}" class="avatar md">
        </div>
        <div class="subf cmg-smb border-b">
            <div class="sub cmg-smr">
            <a id="username" href="{{ url('u') .  '/' . $comment->user->id }}" target="_blank" class="sp redf">
                @if($comment->user->verification == 4)<i class="fa fa-vimeo orange"><span class="orange sp tn">主播</span></i>@endif
                {{ $comment->user->username }}</a><p class="lv @if($comment->user->admin) red @elseif($comment->user->level>=15) pink @elseif($comment->user->level>=10) orange @elseif($comment->user->level>=5) green @else blove @endif">@if($comment->user->admin) 管理员 @else Lv.{{ $comment->user->level }} @endif</p></div>
            <p id="content" class="md">{{ $comment->item_comment_content }}</p>
            <div class="subw cmg-mdr">
                <p id="loft" class="sm grey">#{{ ($pager->page-1)*10 + $loop->index + 1 }}</p>
                <p class="sm grey">{{ $comment->created_at }}</p>
                <a href="javascript:;" class="redf" data-commentid="{{ $comment->id }}">回复</a>

            </div>
            @if($comment->children)
                @foreach($comment->children as $comment)
            <div class="subw">
                <div class="subw cmg-tnr">
                    <a href="{{ url('u') .  '/' . $comment->user->id }}" target="_blank" class="sp redf">{{ $comment->user->username }}</a>
                    <p class="tn grey">{{ $comment->created_at }}</p>
                    <br>
                    <p class="sm grey"> {{ $comment->item_comment_content }}</p>
                </div>
            </div>
                @endforeach
            @endif
        </div>
    </div>
    @endforeach
    <div class="padding-bg">
        <div class="pager fright padding-hg"></div>
        <script>
            initPager();
            function initPager() {
                $(".pager").createPage({
                    showIndi: false,
                    pageNum: {{ $pager->total }},//总页码
                    current: {{ $pager->page }},//当前页
                    backfun: function(e) {
                        transData = {
                            page: e.current
                        };
                        $last.trigger('click');
                    }
                });
            }
        </script>

        <div class="subw cmg-smr">

            <i class="hr"></i>
            <div class="col-1 vert-tn"></div>
            <div class="box-horizon">
                @if(!session('user'))<div class="info padding-md abso-center">
                    <p class="tn width-400 center">你需要先<a href="{{ url('/login') }}" class="redf"> 登录 </a>或<a href="{{ url('/register') }}" class="redf"> 注册 </a>后才能评论...</p></div>
                @elseif (!$pay)
                    <div class="info padding-md abso-center">
                        <p class="tn width-400 center">你需要先<a href="{{ url($itemid.'/buy') }}" class="redf"> 赞助该项目 </a>后才能评论...</p></div>
                @endif
                    <textarea cols="50" name="comment" rows="3" data-parent="0" placeholder="" @if(!session('user') || !$pay) disabled @endif></textarea>
                <button id="commentSubmit" class="red vert-tn" @if(!session('user') || !$pay) disabled @endif>发表评论</button>
            </div>
        </div>

    </div>
    {!! Geetest::render('bind') !!}
    <script>
        initComment();
    </script>
    @else
    <div class="padding-bg">

        <h4>暂无评论...</h4>

        <div class="vertmg-md"></div>

        <div class="subw cmg-smr">

            <i class="hr"></i>
            <div class="col-1 vert-tn"></div>

            <div class="box-horizon">
                @if(!session('user'))<div class="info padding-md abso-center">
                    <p class="tn width-400 center">你需要先<a href="{{ url('/login') }}" class="redf"> 登录 </a>或<a href="{{ url('/register') }}" class="redf"> 注册 </a>后才能评论...</p></div>
                @elseif (!$pay)
                    <div class="info padding-md abso-center">
                    <p class="tn width-400 center">你需要先<a href="{{ url($itemid.'/buy') }}" class="redf"> 赞助该项目 </a>后才能评论...</p></div>
                @endif

               <textarea cols="50" name="comment" rows="3" data-parent="0" placeholder="" @if(!session('user') || !$pay) disabled @endif></textarea>

                <button id="commentSubmit" class="red vert-tn" @if(!session('user') || !$pay) disabled @endif>发表评论</button>
            </div>
        </div>

    </div>
    {!! Geetest::render('bind') !!}
    <script>
        initComment();
    </script>

@endif