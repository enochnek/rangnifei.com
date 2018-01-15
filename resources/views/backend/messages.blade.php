
<ul class="padding-sm cmg-smb" data-view>
	@foreach($letters as $letter)

	<li class="border">
		<div class="bgr bgr-grey">
			<div class="subw">
			<p class="md"><strong>{{$letter->title}}</strong></p>
			<p class="sm fright">{{$letter->created_at}}</p></div>
		</div>
		<div class="depth-1 padding-sm">
			<p class="md">{{$letter->content}}</p>
		</div>
	</li>
	@endforeach
</ul>
<div class="pager fright padding-md"></div>


<script>
    initPager();
    function initPager() {
        $(".pager").createPage({
            showIndi: false,
            pageNum: {{ $pager->total }},//总页码
            current: {{ $pager->page }},//当前页
            backfun: function (e) {
                transData = {
                    page: e.current
                };
                $last.trigger('click');
            }
        });
    }
</script>
