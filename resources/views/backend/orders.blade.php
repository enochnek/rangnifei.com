@if (count($orders))
<ul class="padding-sm cmg-bgb" data-view>
	@foreach($orders as $order)

		<li class="border">
		<div class="depth-4 box-horizon">
			<p class="sm">订单号: {{ $order->order_number }}</p>
			<p class="grey sm">{{ date('Y年m月d日 H:i:s', strtotime($order->created_at)) }}</p>

			<p class="grey sm">王者荣耀赞助赛</p>
		</div>
		<div class="depth-1 vert-md subw">
			<div class="col-3 fheight">
				<img src="{{ $order->item->item_coverurl }}" class="fheight offset-right bg">
			</div>
			<div class="col-7 fheight border-r padding-sm">
				<div class="cmg-smb">
					<p class="line bg">{{ $order->item->item_title }}</p>
					<div class="subw cmg-mdr">
						<p class="sm grey">发起人: <a href=" {{ url('user') .  '/' . $order->user->id }}" class="tn bold red">{{ $order->user->username }}</a></p>
						<p class="sm grey col-7 line">选项: @if($order->order_optionid)<strong class="tn">￥{{ $order->option->item_option_cost }} {{ trim($order->option->item_option_title) }}</strong> @else <strong class="tn">￥{{ $order->order_cost / $order->order_amount }} 自定义赞助额度</strong> @endif</p>

					</div>

					<p class="sm announce line"><i class="fa fa-paper-plane-o">@if(isset($order->announcement->id)) {{ date('m月d日 H:i', strtotime($order->announcement->created_at)) }}</i>: {{ $order->announcement->item_anno_content }} @else </i> 暂无公告 @endif</p>
				</div>
				<div class="cmg-mdr vertmg-tn">
					<a href="{{ url('/'.$order->order_itemid) }}" class="red" target="_blank">查看项目</a>
					<a href="{{ $order->item->item_weburl }}" class="red" target="_blank">观看直播</a>
					<a href="javascript:;" name="showAnnouncements" data-itemid="{{$order->item->id}}" class="red">比赛公告</a>
				</div>
			</div>
			<div class="col-2 padding-md cmg-mdb">
				<h4 class="red">已赞助</h4>
				<h4>￥{{ $order->order_cost }}</h4>
				<h3 class="blue"># {{ substr((100000+$order->order_serial), 1) }}</h3>
			</div>
		</div>
	</li>
	@endforeach
</ul>

<div class="pager fright padding-md"></div>
<script>
    initPager();
    initItemView();
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
@else
	<h3 class="padding-bg">还没有参与任何项目, 去首页看看吧!</h3>
@endif