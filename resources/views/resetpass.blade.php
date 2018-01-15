@extends('layouts/base')
@section('content')
	<div class="depth-10 vert-bg"></div>

	<div class="depth-10">
		<div class="container fadeDown">
			<div class="panel-reglog center">
				<div class="padding-bg hidden">
					<h2 class="vertmg-tn">重置密码</h2>
					<hr class="vertmg-sm">
					<form  class="subf" onsubmit="return false;">
						<label for="phone">手机号</label>
						<input name="phone" class="taller"  type="text" placeholder="输入中国11位手机号码...">
						<label for="msgcode">验证码</label>
						<div class="sub">
							<input name="msgcode" class="taller col-7" type="text" placeholder="输入6位手机验证码...">
							<div class="col-5">
								<a href="javascript:;" name="reset" class="button red">发送验证码</a>
							</div>
						</div>
						<label for="password">新密码</label>
						<input name="password" class="taller" type="password" placeholder="设置新密码">
						<input class="button red bg " id="resetPassword" type="submit" value="更改密码">
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
	@endsection