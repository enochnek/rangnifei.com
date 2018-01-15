@extends('layouts/base')
@section('head')
	<script type="text/javascript" src="{{asset('js/jquery.glide.min.js')}}"></script>
@endsection

@section('content')
	@include('subviews.gamePanel')

<div class="depth-10 fullback">
	<div class="dim depth-shade">
		<div class="main vertpd-bg">
			<div class="col-7">
				<div class="slider">
					<ul class="slides">
						@foreach($banners as $banner)


						<li><a class="inform" href="{{ $banner->banner_weburl }}" data-info style="background-image: url({{ $banner->banner_coverurl }})">
							<div class="hinfo box-paragraph fwidth">
								<p class="md">{{ $banner->banner_title }}</p>
								<p class="md">{{ $banner->banner_description }}</p>
							</div>
						</a></li>
 
						@endforeach
					</ul>
				</div>
			</div>
			<div class="col-5 banner-row">
				@foreach($recommandItems as $recommandItem)
				<div class="depth-9" data-info>
					<a href="{{ url('/'.$recommandItem->id) }}" class="hinfo abso-invi"></a>
					<div class="info cmg-smb">
						<p class="sm">人数: {{ $recommandItem->dynamic->num }}</p>
						<p class="sm">金额: {{ $recommandItem->dynamic->sum }}</p>
						<p class="sm">热度: {{ $recommandItem->dynamic->num*15 + $recommandItem->dynamic->sum }}</p>
					</div>

					<img data-src="{{ $recommandItem->item_coverurl }}">
					<div class="fheight padding-md subv">
						<div class="vcol-9">
							<p class="sm line-2">{{ $recommandItem->item_title }}</p>
						</div>
						<div class="vcol-3 cmg-mdr subw">
							<p class="tn">@if($recommandItem->user->verification == 1)<i class="fa fa-vimeo orange"></i>@endif {{ $recommandItem->user->username }}</p>
							<p class="tn fright">{{ $recommandItem->game->game_name }}</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<div class="vert-tn fwidth"></div>

			<div class="fwidth">
				
			</div>
		</div>
	</div>

	<div class="main vertmg-bg">
		@for($i = 0; $i < 4; $i++) @if(isset($orderedItems[$i][0]))
		<div class="depth-3 padding-md fwidth">
			<div class="padding-md depth-4 sub">
				<h2 class="img-md"><img data-src="{{ $orderedItems[$i][0]->game->game_iconurl }}"> {{ $orderedItems[$i][0]->game->game_name }}</h2>
			</div>
			<div class="vertpd-md fright">
				<a href="{{ url('/game/' . $orderedItems[$i][0]->game->id) }}" class="red vcol-2">查看更多</a>
			</div>

			<div class="subw offset-sm cmg-mdb">

				@foreach($orderedItems[$i] as $orderedItem)
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
		</div>

		@if ($advers[$i] != null)
		<div class="depth-lumen vertpd-md">
			<a href="{{ $advers[$i]->banner_weburl }}" target="_blank"><img data-src="{{ $advers[$i]->banner_coverurl }}" class="fwidth vert-sm"></a>
		</div>
		@endif

		@endif @endfor

	</div>
</div>


@endsection

@section('foot')
<script type="text/javascript">

	var glide = $('.slider').glide({
		//autoplay:true,//是否自动播放 默认值 true如果不需要就设置此值
		animationTime:500, //动画过度效果，只有当浏览器支持CSS3的时候生效
		arrows:true, //是否显示左右导航器
		arrowsWrapperClass: "arrowsWrapper",//滑块箭头导航器外部DIV类名
		arrowMainClass:"",//滑块箭头公共类名
		arrowRightClass:"",//滑块右箭头类名
		arrowLeftClass:"",//滑块左箭头类名
		arrowRightText:"",//定义左右导航器文字或者符号也可以是类
		arrowLeftText:"",
		nav:true, //主导航器也就是本例中显示的小方块
		navCenter:true, //主导航器位置是否居中
		navClass:"slider-nav",//主导航器外部div类名
		navItemClass:"slider-nav__item", //本例中小方块的样式
		navCurrentItemClass:"slider-nav__item--current" //被选中后的样式
	});
</script>
@endsection