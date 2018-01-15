
<div class="padding-sm cmg-smb">
	<div class="cmg-mdb depth-1 box">

		<h4 class="padding-sm">基本信息</h4>
		<div class="">
			<i class="hr"></i>
		</div>
		<div class="box-horizon">
			<label class="col-1"><i class="fa fa-user"></i>名字</label>
			<strong class="md">{{ $user->username }}</strong>
			<!-- <label class="col-1 border-l"><i class="fa fa-star"></i>等级</label> -->
			<div class="sub cmg-smr">

				<!-- <label><i class="fa fa-vimeo"></i>身份</label> -->
				@if(!$user->verification)
				<div class="cmg-smr sub">
					<a href="{{ url('/backend/verify') }}" target="_blank" class="lv grey">未认证</a>
					<a href="{{ url('/backend/verify') }}" target="_blank" class="red">申请认证</a>
				</div>
				@else
					@if($user->verification == 4)<i class="fa fa-vimeo orange"><span class="orange sp tn">主播</span></i>@endif
				@endif
				<p class="lv blove">Lv.{{ $user->level }}</p>
			</div>
		</div>
		<div class="box-horizon">
			<label class="col-1"><i class="fa fa-mobile"></i>手机</label>
			<div class="cmg-smr sub">
				{{--<strong class="md">0086 {{ session('user')->phone }}</strong>--}}
				<strong class="md">0086 {{ $user->phone }}</strong>
				{{--<a href="javascript:;" data-become="input" class="red"><i class="fa fa-edit"></i></a>--}}
			    {{--<input class="become" type="text" value="">--}}
            </div>

			<label class="col-1"><i class="fa fa-envelope"></i>邮箱</label>
			<div class="cmg-smr sub">
				<strong class="md">@if($user->email) {{$user->email}} @else - @endif</strong>
				<a href="javascript:;" data-become="input" class="red"><i class="fa fa-edit"></i></a>
				<input name="email" class="become" type="text" value="@if($user->email) {{$user->email}} @endif">
            </div>
		</div>

		<div class="box-horizon">
			<label class="col-1"><i class="fa fa-circle-thin"></i>支付宝</label>
			<div class="cmg-smr sub">
				<strong class="md">@if($user->profile->alipay) {{$user->profile->alipay}} @else - @endif</strong>
				<a href="javascript:;" data-become="input" target="_blank" class="red"><i class="fa fa-edit"></i></a>
				<input name="alipay" class="become" type="text" value="@if($user->profile->alipay) {{$user->profile->alipay}}@endif">
				<p class="sm">填写支付宝以使用系统结算</p>
			</div>

		</div>
	</div>

	<div class="cmg-mdb depth-1 box">

		<h4 class="padding-sm">资料信息</h4>
		<div class="">
			<i class="hr"></i>
		</div>
		<div class="box-horizon">

			<label class="col-1 vertpd-bg">头像</label>
			<div class="up-img-cover sub"   data-info="hover">
				<img class="am-circle avatar" alt="点击图片上传" src="{{ $user->profile->avatar }}"  data-am-popover="{content: '点击上传', trigger: 'hover focus'}" >
				<a href="javascript:;" class="vertmg-md hinfo padding-sm tn">上传新头像</a>
				<input type="file" id="fileElem" style="display: none;">
			</div>
			{{--<input type="file">--}}
		</div>



		<div class="box-horizon">
			<label class="col-1 vertpd-tn" for="qq">性别</label>
			<ul name="sex" class="group sub border">
				<li class="inner-links @if ($user->profile->sex == 0) active @endif"><a href="javascript:;" class="redf square">保密</a></li>
				<li class="inner-links @if ($user->profile->sex == 1) active @endif"><a href="javascript:;" class="redf square">男</a></li>
				<li class="inner-links @if ($user->profile->sex == 2) active @endif"><a href="javascript:;" class="redf square">女</a></li>
			</ul>
		</div>
		<div class="box-horizon">
			<label class="col-1 vertpd-tn" for="qq">QQ</label>
			<input name="qq" class="sp" type="text" placeholder="输入QQ号码..." value="{{ $user->profile->qq }}">
			<p class="sm vertpd-tn">QQ和微信用于赞助时, 发起人与您联系的方式</p>
		</div>
		<div class="box-horizon">
			<label class="col-1 vertpd-tn">微信</label>
			<input name="wechat" class="sp" type="text" placeholder="输入微信号码..." value="{{ $user->profile->wechat }}">
		</div>
		<div class="box-horizon">
			<label class="col-1">个人介绍</label>
			<textarea name="intro" cols="67" rows="4" class="bold">{{ $user->profile->introduction }}</textarea>
		</div>

		<div class="col-10 hidden">
			<button id="profileSubmit" class="red fright sp">保存资料</button>
		</div>
	</div>
</div>
<script>
    uploadId = 'fileElem';
</script>
<script type="text/javascript" src="{{ asset('aliyunoss/lib/plupload-2.1.2/js/plupload.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('aliyunoss/upload.js') }}"></script>
<script type="application/javascript">
	initProfileSave({{ $user->profile->sex }});
    $("[data-become]").click(function() {
        console.log('test');
        var _ = $(this).siblings('.become');
        _.css('display', 'block');
        $(this).css('display', 'none');
        $(this).prev().css('display', 'none');
    });
</script>

