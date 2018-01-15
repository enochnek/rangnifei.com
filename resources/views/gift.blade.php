@extends('layouts/base')
@section('content')

<div class="depth-10 vert-bg"></div>

<div class="depth-10 center dim">
	<img src="{{asset('images/gift.png')}}">
	<h1>获得了注册红包 <br><span class="red">{{$price}}</span> 元！</h1>
	<br>
	<p>每邀请一人注册, 可领与他同样数额注册红包. 最高500元</p>
	<br>

	<p>您的邀请链接:
		<input type="text" id="url" value="http://www.rangnifei.com/register/{{$userid}}">
		<a href="javascript:;" onClick="copyUrl();"> 复制链接</a>
	</p>
</div>

<div class="vert-hg depth-10"></div>
@endsection
@section('foot')
	<script>
		function copyUrl() {
            url.select();
            document.execCommand('Copy');
            $.loading("复制链接成功!",1500);
        }

	</script>
@endsection