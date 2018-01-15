@extends('layouts/base')
@section('content')


	<div class="depth-10 vert-sm"></div>


	<div class="depth-10 cmg-bgb">
		<div class="main vert-md">
			<div class="col-4">
				<div class="box-trans dim">
					<div class="box-profile">
						<a href="" class="hinfo">修改资料</a>
						<img src="{{ $userInfo->profile->avatar }}" class="avatar">
						<strong class="">{{ $userInfo->username }}</strong>

						<p class="md">@if ($userInfo->profile->introduction) {{$userInfo->profile->introduction}} @else 很惭愧，还没有填写个人说明... @endif</p>
					</div>
				</div>
			</div>

			<div class="col-8">
				<div class="depth-1 vert-md box-off">
					<div class="bgr-red col-3 fheight dim">
						<p class="center vertpd-bg gt"><strong>￥{{$userInfo->money}}</strong><br><span class="bg">余额</span><br><button style="background-color: transparent; color: #CCC; border: 1px solid #AAA; padding: 4px 6px;">提现</button></p>
						
					</div>
					<div class="depth-4 col-3 fheight" style="padding: 5px; 12px;">
						<p class="center vertpd-bg gt"><strong>{{ $userInfo->dynamic->myCostTotal }}</strong><br><span class="bg">总赞助额</span></p>
					</div>
					<div class="padding-bg col-6 cmg-mdb">
						<div class="subw cmg-mdr">
							<label class="col-3">总赞助次数</label>
							<strong class="md">{{ $userInfo->dynamic->myOrdersCount }} 次</strong>
						</div>
						<div class="subw cmg-mdr">
							<label class="col-3">邀请用户数</label>
							<strong class="md">{{ $userInfo->dynamic->myUserCount }} 人</strong>
						</div>
						<div class="subw cmg-mdr">
							<label class="col-3">邀请红包</label>
							<strong class="md"><span class="red">￥{{ $userInfo->dynamic->myInvitation }}</span> / 500</strong>
						</div> 
					</div>
				</div>
			</div>
		</div>

		<div class="main">
			<div class="depth-3 subw">
				<div class="col-3">
					<div class="offset-right bg">
						<ul class="box-zebra inner-links group">
							<h4 class="divide depth-4">个人中心</h4>
							<li class="active"><a href="javascript:;" data-viewurlp="orders"><i class="fa fa-flag"></i> 我参与的</a></li>
							<li><a href="javascript:;" data-viewurlp="favorites"><i class="fa fa-heart"></i> 我关注的</a></li>
							<li><a href="javascript:;" data-viewurlp="profile"><i class="fa fa-user"></i> 个人资料</a></li>
							<li><a href="javascript:;" data-viewurlp="messages"><i class="fa fa-envelope-o"></i> 站内信 @if($letter>0) ({{$letter}}) @endif </a></li>
							<li><a href="javascript:;" data-viewurlp="verify"><i class="fa fa-vimeo"></i> 帐号认证</a></li>
							<h4 class="divide inner-links">我的项目 <a href="{{url('/backend/publish')}}" class="blue padding-md" style="color: #FFF;">发布比赛<i class="fa fa-plus"></i></a></h4>
							<li><a href="javascript:;" data-viewurlp="myitems"><i class="fa fa-star"></i> 我发起的</a></li>
							
						</ul>
						<div class="vert-tn"></div>
					</div>

				</div>

				<div class="col-9">
					<div class="vert-tn"></div>
					<div data-view>

					</div>
				</div>

			</div>
		</div>
	</div>


	<div class="vert-lg depth-10"></div>

@endsection
@section('foot')
	<script type="text/javascript" src="{{asset('js/js_backend.js')}}"></script>
	<script>
		removeCache(undefined, '-Backend');
		//removeCache('messages-Backend');
		//removeCache('orders-Backend');
		//removeCache('favorites-Backend');
		//removeCache('profile-Backend');
		//removeCache('verify-Backend');
		//removeCache('myitems-Backend');
		
		initViewurl('-Backend');
		
        webUrl = "{{ url('/backend') }}" + "/";
        //cacher('orders', $('[data-view]').html());


	</script>

@endsection