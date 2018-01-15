@if (count($myItems))
<ul class="padding-sm cmg-bgb" data-view>
	@foreach($myItems as $item)
	<li class="border">
		<div class="depth-9 box-horizon dim">
			<strong class="sm">编号: {{ $item->id }}</strong>
			<p class="sm">{{ date('Y年m月d日 H:i:s', strtotime($item->created_at)) }}</p>
			<p class="sm">{{ $item->game->game_name }}{{ $item->item_cata_name }}</p>

			
		</div>
		<div class="depth-1 vert-md subw">
			<div class="col-3 fheight">
				<img src="{{ $item->item_coverurl }}" class="fheight offset-right bg">
			</div>
			<div class="col-7 fheight border-r padding-sm">
				<div class="cmg-smb">
					<p class="line bg">{{ $item->item_title }}</p>
					<div class="subw cmg-mdr">
						<p class="sm grey">人数: <strong class="red">{{ $item->dynamic->num }}</strong></p>
						<p class="sm grey">总额: <strong class="red">￥{{ $item->dynamic->sum }}</strong></p>
						<p class="sm grey">下次结算: <strong>{{ substr($item->next_settle_date, 0, 10) }}</strong></p>
					</div>
					<p class="sm announce line"><i class="fa fa-paper-plane-o">@if(isset($item->announcement->id)) {{ date('m月d日 H:i', strtotime($item->announcement->created_at)) }}</i>: {{ $item->announcement->item_anno_content }} @else </i> 暂无公告 @endif</p>
				</div>
				<div class="cmg-mdr vertmg-tn">
					<button name="showSponsors" data-itemid="{{$item->id}}" class="lv red">赞助列表</button>
					<button name="showAnnouncements" data-itemid="{{$item->id}}" class="lv blue">发布公告</button>
					<a href="{{ url('/'.$item->id) }}" class="red" target="_blank">查看项目</a>
					<a href="{{ url('/edit/'.$item->id) }}" class="red">编辑项目</a>
					<button name="showSettles" data-itemid="{{$item->id}}" class="lv orange">历史结算</button>
				</div>
			</div>
			<div class="col-2 padding-md cmg-mdb">
				<h5>比赛状态:</h5>
				<h4 class=" @if($item->item_status == 0 || $item->item_status == 5) red
							@elseif($item->item_status == 2 || $item->item_status == 3) blove
							@elseif($item->item_status == 4) grey
							@elseif($item->item_status == 6) green
				@endif ">{{ $item->item_status_name }}</h4>
				<button class="white square fwidth" data-itemid="{{$item->id}}"  name="updateStatus">更改状态</button>
			</div>
		</div>
	</li>
	@endforeach
</ul>
<div class="pager fright padding-md"></div>


<script>
    initItemView();
    initViewurl();
    initPager();
    initUpdate();
    function initPager() {
        $(".pager").createPage({
            showIndi: false,
            pageNum: {{ $pager->total }},//总页码
            current: {{ $pager->page }},//当前页
            backfun: function (e) {
                transData = {
                    page: e.current
                };
                $last.trigger('click');
            }
        });
    }

</script>

@else
	<h3 class="padding-bg">还没有发起任何项目, <a href="{{ url('/backend/publish') }}">点击这里</a>发布一场比赛项目</h3>
@endif