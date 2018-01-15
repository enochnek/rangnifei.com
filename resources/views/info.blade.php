@extends('layouts/baseItem')

@section('title', $itemInfo->item_title)
@section('inviterId', $itemInfo->user->id)

@section('content')


	<div class="depth-10 vert-sm"></div>
	<div class="depth-10">
		<div class="main depth-1">

			<div class="col-6">
				<img src="{{ $itemInfo->item_coverurl }}" class="hg" data-src>
			</div>

			<div class="col-6">
				<div class="depth-4 subo fwidth">
					<div class="padding-sm">
						<h3 class="dim"><span class="red">{{ $itemInfo->item_status_name }}</span> {{ $itemInfo->game->game_name }} {{ $itemInfo->item_cata_name }}</h3>
						<p class="grey sm">开始于: {{ date('Y年m月d日 H:i:s', strtotime($itemInfo->created_at)) }}@if ($itemInfo->item_status == 5)- 结束于: {{ date('Y年m月d日', strtotime($itemInfo->ended_at)) }}@endif</p>
					</div>
					<div class="fright subo">
						<div class="subo inner-links">
							<a href="javascript:;" class="square" data-dropdown="hover"><i class="fa fa-share-alt img-sm"></i><br>分享</a>
							<div class="share dropdown depth-1">
								<div class="">
								<script src="http://connect.qq.com/widget/loader/loader.js" widget="shareqq" charset="utf-8"></script>
								<a href="javascript:;" class="jiathis_button_weixin img-sm"><i class="fa fa-share-alt"></i><br> 微信分享</a>
								<a name="weibo"  class="img-sm" href="javascript:;" target="_blank"><i class="fa fa-share-alt"></i><br> 微博分享</a>
								</div>
							</div>
							@if($isFavorite)
								<a href="javascript:;" name="unfav"  data-url="{{ url('/api/v1/user/item/unfav') }}" data-itemid="{{$itemInfo->id}}" class="square"><i class="fa fa-heart img-sm red"></i><br>已关注</a>
								<a href="javascript:;" name="fav" style="display: none;"  data-url="{{ url('/api/v1/user/item/fav') }}" data-itemid="{{$itemInfo->id}}" class="square"><i class="fa fa-heart-o img-sm"></i><br>关注</a>
							@else
								<a href="javascript:;" name="unfav" style="display: none;"  data-url="{{ url('/api/v1/user/item/unfav') }}" data-itemid="{{$itemInfo->id}}" class="square"><i class="fa fa-heart img-sm red"></i><br>已关注</a>
								<a href="javascript:;" name="fav"  data-url="{{ url('/api/v1/user/item/fav') }}" data-itemid="{{$itemInfo->id}}" class="square"><i class="fa fa-heart-o img-sm"></i><br>关注</a>
							@endif
						</div>
					</div>
				</div>

				<div class="introduce">
					<div class="vcol-7 cmg-mdb">
						<p class="bold line-2">{{ $itemInfo->item_title }}</p>
						<p class="sm grey">{{ $itemInfo->item_description }}</p>
						<p class="sm grey">@if( $itemInfo->item_players )参赛选手: {{ $itemInfo->item_players }} @endif</p>
					</div>
					<div class="vcol-3 cmg-smb">
						<div class="progress red">
							<div class="padding-sm" style="@if ($itemInfo->item_expect == 0)width: 100%;@else width: {{ floor(($itemInfo->dynamic->sum/$itemInfo->item_expect)*100) }}%;@endif"></div>
						</div>
						<div class="three sm">
							<p><strong>{{ $itemInfo->dynamic->num }}</strong><br>参与次数</p>
							<p><strong>{{ $itemInfo->dynamic->sum }}</strong><br>参与奖金</p>
							<p><strong>@if ($itemInfo->item_expect == 0)--%@else{{ floor(($itemInfo->dynamic->sum/$itemInfo->item_expect)*100) }}%@endif</strong><br>完成度</p>
						</div>
					</div>
					<div class="vcol-2 subw">
						<div class="col-9 sub">
							@if ($itemInfo->is_sponsor && !($self))
								<a href="{{ url($itemInfo->id.'/buy') }}" class="button red gt">赞&nbsp&nbsp助</a>
							@elseif ($self)
								<a href="javascript:;" disabled class="button red gt">我的项目</a>
							@else
								<a href="javascript:;" disabled class="button red gt">{{ $itemInfo->item_status_name }}</a>
							@endif
						</div>
						<div class="col-3 subw">
							<a href="{{ $itemInfo->item_weburl }}" target="_blank" class="redf center"><i class="fa fa-link"></i> 观看比赛直播</a>
						</div>
					</div>
				</div>
			</div>
			<div class="subw depth-4">
				<div class="group box-tab">
					<button class="active" data-viewurlp="info">详细介绍</button>
					<button class="" data-viewurlp="comments">评论({{ $itemInfo->dynamic->comments_count }})</button>
					<button class="" data-viewurlp="history">历届资源</button>
					<a class="button" href="{{url('/') . '/u/' . $itemInfo->user->id}}" target="_blank">发起人</a>

				</div>


				<div class="col-8">
					<div class="depth-1 padding-md cmg-mdb" data-view>

						@if(count($itemInfo->announcements))
							@foreach($itemInfo->announcements as $anno)
							<div class="padding-md bgr-grey">
								<p class="sm"><span class="grey">{{ date('Y年m月d日 H:i:s', strtotime($anno->created_at)) }}</span><br><strong>{{ $anno->item_anno_content }}</strong></p>
							</div>
							@endforeach
						@endif

						<i class="hr"></i>
						<div class="vertpd-md">
						{!! $itemInfo->item_text !!}
						</div>

					</div>
				</div>

				<div class="col-4">
					<div class="depth-1 padding-bg offset-left">

						<div class="box-profile">
							<img src="{{ $itemInfo->user->avatar }}" class="avatar">
							<a href="{{ url('/u') . '/' . $itemInfo->user->id }}" class="sp red" target="_blank">@if($itemInfo->user->verification == 4)<i class="fa fa-vimeo orange"><span class="orange sp tn">主播</span></i>@endif {{ $itemInfo->user->username }}</a>
							<p class="md">@if($itemInfo->user->introduction) {{ $itemInfo->user->introduction }} @else 很惭愧，还没有填写个人说明... @endif</p>
						</div>
					</div>


					@if ($itemInfo->rank)
						<div class="depth-1 offset-left">
							<div class="vertmg-sm"></div>
							<div class="padding-bg cmg-mdb">
								<h3>参与排行</h3> </div>
							<div class="">
								<ul class="box-zebra">
									@foreach($itemInfo->rank as $rank )
										<li>
											<div class="subw cmg-smr">
												<h3 class="padding-sm red">No.{{ $loop->index+1 }}</h3>
												<img src="{{ $rank->avatar }}" class="avatar sm">
												<div class="cmg-smb">
													<a href="" class="redf tn">{{ $rank->username }}</a>
													<p class="tn">赞助: {{$rank->sum}}元 参与: {{$rank->amount}}次</p>
												</div>
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					@endif

					<div class="depth-1 offset-left">
						<div class="vertmg-sm"></div>
						<div class="cmg-mdb">
							<div class="padding-md">
							<h3>赞助选项</h3>
							</div>
							<i class="hr"></i>
							<ul class="cmg-mdb">
								@foreach($itemInfo->options as $option)
								<li>
									<div class="cmg-smr">
										<h3 class="red">&nbsp;&nbsp;￥{{ $option->item_option_cost }}</h3>
										<p class="tn bgr bgr-grey padding-sm"><strong>{{ $option->item_option_title }}</strong></p>
									</div>
								</li>
								@endforeach
							</ul>
							<div class="vertpd-tn"></div>
						</div>
					</div>
					<div class="vertmg-md fwidth"></div>

				</div>

			</div>
		</div>
	</div>

	<div class="vert-lg depth-10"></div>


@endsection
@section('foot')

	<script type="text/javascript" src="{{asset('js/js_info.js')}}"></script>
	<script>
        initViewurl({{$itemInfo->id}});
        $("[name=weibo]").click(function () {
            console.log(1);
            shareUrl = 'http://service.weibo.com/share/share.php?appkey=&title=' + '{{ $itemInfo->item_title}}'  + '  {{ $itemInfo->item_description }}' +  '&url=' + location.href  + '&pic=' + '{{ $itemInfo->item_coverurl }}';
            $(this).attr('href',shareUrl);
            $(this).trigger();
        });
        webUrl = "{{ url('/'.$itemInfo->id) }}" + "/";
        removeCache(undefined, {{$itemInfo->id}});
		cacher('info' + {{$itemInfo->id}}, $('[data-view]').html());
	</script>

<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1" charset="utf-8"></script>
<script type="text/javascript">

    (function(){
        var p = {
            url:location.href, /*获取URL，可加上来自分享到QQ标识，方便统计*/
            title:'{{ $itemInfo->item_title}}',  /*分享标题(可选)*/

            desc:'{{ $itemInfo->item_description }}',/*分享理由(风格应模拟用户对话),支持多分享语随机展现（使用|分隔）*/
            summary:'', /*分享摘要(可选)*/
            pics:'{{ $itemInfo->item_coverurl }}', /*分享图片(可选)*/
            flash: '', /*视频地址(可选)*/
            site:'QQ分享', /*分享来源(可选) 如：QQ分享*/
            style:'201',
            width:32,
            height:32
        };
        var s = [];
        for(var i in p){
            s.push(i + '=' + encodeURIComponent(p[i]||''));
        }
        $('.share').append(['<a class="img-sm" href="http://connect.qq.com/widget/shareqq/index.html?',s.join('&'),'" target="_blank"><i class="fa fa-share-alt"></i><br> QQ分享</a>'].join(''));
    })();

</script>


@endsection