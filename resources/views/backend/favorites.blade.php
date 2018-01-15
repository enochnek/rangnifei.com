@if (count($favorites))
<ul class="padding-sm cmg-mdb sub">
    @foreach($favorites as $favorite)

    <li class="col-6">
        <div class="depth-1 offset-right sub">
            <div class="vert-md subo" data-info>
                <a href="{{ url('/' . $favorite->id ) }}" target="_blank" class="hinfo abso-invi"></a>

                <div class="col-5 vert-md">
                    <img src="{{ $favorite->item_coverurl }}" class="fheight fwidth bg">
                </div>
                <div class="col-7 fheight box-paragraph">
                    <div class="vcol-9 cmg-mdb">
                        <p class="line-2 sm">{{ $favorite->item_title }}</p>
                        <p class="sm">状态: <strong class="tn">{{ $favorite->item_status_name }}</strong></p>
                    </div>
                    <p class="tn vcol-3"><strong>@if($favorite->user->verification == 4)<i class="fa fa-vimeo orange"><span class="orange sp tn">主播</span></i>@endif {{ $favorite->user->username }}</strong></p>
                </div>
            </div>
        </div>
    </li>

        @endforeach
</ul>

<div class="pager fright padding-md"></div>
<script>
    initPager();
    function initPager() {
        console.log(1);
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
@else
    <h3 class="padding-bg">还没有关注任何项目, 去首页看看吧!</h3>
@endif