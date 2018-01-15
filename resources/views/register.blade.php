@extends('layouts/base')
@section('content')
	<div class="depth-10 vert-bg"></div>

	<div class="depth-10">
		<div class="container fadeDown">
			<div class="panel-reglog center">
				<div class="padding-bg hidden">
					<h2 class="vertmg-tn">注册</h2>
					<hr class="vertmg-sm">
					<form id="register" class="subf">
						<label for="phone">手机号</label>
						<input name="phone" class="taller" type="text" placeholder="输入中国11位手机号码...">
						<label for="msgcode">验证码</label>
						<div class="sub">
							<input name="msgcode" class="taller col-7" type="text" placeholder="输入6位手机验证码...">
							<div class="col-5">
								<a href="javascript:;" class="button red">发送验证码</a>
							</div>
						</div>
						<label for="username">名字</label>
						<input name="username" class="taller" type="text" placeholder="输入常用名字(建议游戏名字)...">
						<label for="password">密码</label>
						<input name="password" class="taller" type="password" placeholder="输入6位数以上密码...">
						<input class="button red bg" type="submit" value="注册">
					</form>
					<p id="errorMsg" class="sp red fleft">Error</p>
				</div>
			</div>
		</div>
	</div>

	<div class="vert-hg depth-10"></div>

@endsection
@section('foot')
	<script type="text/javascript" src="{{asset('js/auth.js')}}"></script>
	@if(isset($inviterId))
	<script>
		inviterId = {{ $inviterId }};
	</script>
	@endif
	@endsection