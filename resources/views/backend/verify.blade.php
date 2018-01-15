@if($verify->status == 0)
	<div class="padding-sm cmg-smb">
		<div class="cmg-mdb depth-1 box">

			<h4 style="color: red;">认证正在审核中...</h4>

			<div class="">
				<i class="hr"></i>
			</div>
			<h4>以下是你的认证信息</h4>
			<p class="col-8">您的直播间地址 <span class="sm grey">{{$verify->radio_url}}</span></p>

			<div class="subw cmg-bgr">
				<div class="col-5 cmg-smb">
					<img class="col-12" id="frontImg"  src="{{$verify->front_img}}" alt="">
				</div>
				<div class="col-5 cmg-smb">
					<img class="col-12" id="backImg" src="{{$verify->back_img}}" alt="">
				</div>
			</div>



		</div>
	</div>
	@elseif ($verify->status == 1)
	<div class="padding-sm cmg-smb">
		<div class="cmg-mdb depth-1 box">

			<h4 style="color: red;">认证成功</h4>

			<div class="">
				<i class="hr"></i>
			</div>
			<h4>以下是你的认证信息...</h4>


			<p class="col-8">您的直播间地址 <span class="sm grey">{{$verify->radio_url}}</span></p>

			<div class="subw cmg-bgr">
				<div class="col-5 cmg-smb">
					<img class="col-12" id="frontImg"  src="{{$verify->front_img}}" alt="">
				</div>
				<div class="col-5 cmg-smb">
					<img class="col-12" id="backImg" src="{{$verify->back_img}}" alt="">
				</div>
			</div>

		</div>
	</div>
	@else
	<div class="padding-sm cmg-smb">
		<div class="cmg-mdb depth-1 box">

			<h4>选择认证类型</h4>

			<div class="">
				<i class="hr"></i>
			</div>

			<ul class="group box-bordergroup">
				<li class="col-4 depth-1 active"><p class="lg"><i class="fa fa-vimeo orange"></i>游戏主播<br><span class="grey sm"> 在直播网站直播间关注量500以上即可申请主播认证</span></p></li>
				<li class="col-4 depth-1"><p class="lg"><i class="fa fa-vimeo"></i>职业玩家<br><span class="grey sm"> 需要提供职业战队的成员证, 即可认证为职业玩家</span></p></li>
				<li class="col-4 depth-1"><p class="lg"><i class="fa fa-vimeo blue"></i>官方<br><span class="grey sm"> 提供和注册名相关的举办方材料, 即可认证为举办官方</span></p></li>
			</ul>


			<h4>提交认证材料</h4>

			<div class="">
				<i class="hr"></i>
			</div>

			<p class="col-8">请输入您的直播间地址 <span class="sm grey">如: www.douyu.com/123</span></p>
			<input name="url" class="col-12">

			<div class="subw cmg-bgr">
				<div class="col-5 cmg-smb">
					<button id="front">上传身份证正面</button>
					<img class="col-12" id="frontImg"  src="" alt="">
				</div>
				<div class="col-5 cmg-smb">
					<button id="back">上传身份证反面</button>
					<img class="col-12" id="backImg" src="" alt="">
				</div>
			</div>

			<input type="file" id="fileElem" style="display: none;" >

			<button id="submit" class="red">提交认证</button>

		</div>
	</div>
	@endif
<div class="pager fright padding-md"></div>

<script>
    uploadId = 'fileElem';
</script>
<script type="text/javascript" src="{{ asset('aliyunoss/lib/plupload-2.1.2/js/plupload.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('aliyunoss/upload.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/verify.js') }}"></script>
