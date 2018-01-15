
    <div class="dialog container" style="top: 30px;" data-dialog="dialog">
        <div class="container-gt depth-1">

            <div class="box-table">
                <div class="subw">


                    <label class="col-1">ID</label>
                    <label class="col-1">状态</label>
                    <label class="col-3">结算时间</label>
                    <label class="col-2">结算金额</label>
                    <label class="col-2">结算人数</label>
                    <label class="col-3">时间周期</label>
                </div>

                @if(isset($settles) && count($settles))

                    @foreach($settles as $settle)

                        <div class="subw">
                            <p class="col-1">{{$settle->id}}</p>
                            <p class="col-1">{{ config("W.SETTLE_STATUS_" . $settle->settle_status)}}</p>
                            <p class="col-3">{{$settle->settle_date}}</p>
                            <p class="col-2">{{$settle->settle_sum}}</p>
                            <p class="col-2">{{$settle->settle_num}}</p>
                            <p class="col-3">{{$settle->settle_delay}}</p>



                            {{--<p class="col-1"><strong>{{ $settle->id }}</strong></p>--}}
                            {{--<a href="{{ url('/' . $settle->settle_itemid) }}" class="col-3 line red">[{{ $settle->settle_itemid }}] {{ $settle->item->item_title }}</a>--}}
                            {{--<a href="javascript:;" class="col-1 line red">{{ $settle->user->username }}</a>--}}
                            {{--<p class="col-1 @if($settle->settle_status == 0) red @endif "><strong>{{ $settle->settle_status_name }}</strong></p>--}}
                            {{--<p class="col-1 red"><strong>￥{{ $settle->settle_sum }}</strong></p>--}}
                            {{--<p class="col-1 blue"><strong>{{ $settle->settle_num }}</strong></p>--}}
                            {{--<p class="col-2"><strong>{{ $settle->settle_date }}</strong></p>--}}
                            {{--@if($settle->settle_status != 1)--}}
                                {{--<div class="sub col-2">--}}
                                    {{--<a href="javascript:;" name="pay" data-settleid="{{ $settle->id }}" data-userid="{{$settle->user->id}}" class="red">结算</a>--}}
                                    {{--<a href="javascript:;" name="delay" data-settleid="{{ $settle->id }}" data-userid="{{$settle->user->id}}" class="red">推迟</a>--}}
                                    {{--<a href="javascript:;" name="reject" data-settleid="{{ $settle->id }}" data-userid="{{$settle->user->id}}" class="red">驳回</a>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        </div>

                    @endforeach

                @else
                    <center>暂无结算信息</center>
                @endif
            
            </div>
            <div class="vertmg-sm sub">
				<button onclick="$.cancel('dialog');" class="fleft">关闭</button>
            </div>
            <div class="pager2 fright padding-md"></div>

        </div>
    </div>
    <script>
        initPager();
        function initPager() {
            $(".pager2").createPage({
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