@extends('layouts/base')
@section('head')
	<script type="text/javascript" src="{{asset('js/jquery.glide.min.js')}}"></script>
@endsection

@section('content')
	@include('subviews.gamePanel')

<div class="depth-10 fullback">

	<div class="vert-tn dim">
		<h3 class="center padding-lg"><img src="{{ $gameicon }}" class="img-md"> {{ $keyword }}</h3>
	</div>

	@if(isset($items) && count($items))
	<div class="main vertmg-bg">
		<div class="depth-3 padding-md fwidth">

			<div class="subw offset-sm cmg-mdb">
				@foreach($items as $orderedItem)
				<div class="col-6 hidden">
					<div class="depth-1 vert-160" data-info>
						<a href="{{ url('/'.$orderedItem->id) }}" class="hinfo abso-invi"></a>
						<div class="hinfo col-5 box-info">
							<p class="vcol-9 sm">{{ $orderedItem->item_description }}</p>
							<div class="vcol-3 subw">
								<a href="{{ url('/u/'.$orderedItem->user->id) }}" class="border">查看发起人</a>
								<a href="{{ url('/'.$orderedItem->id.'/buy') }}" class="border fright">赞助</a>
							</div>
						</div>
						<div class="col-5 fleft">
							<img data-src="{{ $orderedItem->item_coverurl }}" class="fwidth vert-160">
						</div>
						<div class="box-paragraph fheight">
							<div class="vcol-10 cmg-mdb">
								<p class="sp line-2">{{ $orderedItem->item_title }}</p>
								@if($orderedItem->item_players)
								<p class="sm grey">参赛选手: {{ $orderedItem->item_players }}</p>
								@else
								<p class="sm grey">{{ $orderedItem->item_description }}</p>
								@endif
							</div>
							<div class="vcol-2 subw">
								<p class="sm">@if($orderedItem->user->verification == 4)<i class="fa fa-vimeo orange"></i>@endif {{ $orderedItem->user->username }}</p>
								<p class="sm fright"><i class="fa fa-user"></i> {{ $orderedItem->dynamic->num }}</p>
							</div>
						</div>
					</div>
				</div>
				@endforeach

			</div>
			<div class="pager fright padding-md"></div>
		</div>


	</div>
		<div class="vert-md"></div>
	@else
		<div class="center vertmg-bg dim">
			<h3>暂无项目</h3>
		</div>
		<div class="vert-hg"></div>
	@endif
</div>


@endsection

@section('foot')
	<script>
	$(".pager").createPage({
		showIndi: false,
		pageNum: {{ $pager->total }},//总页码
		current: {{ $pager->page }},//当前页
		backfun: function (e) {
			var url = "{{ url('/game').'/'.$gameid }}";

			var address = url + '?page=' + e.current;
			window.location.href=address;
		}
	});
	</script>
	@endsection
