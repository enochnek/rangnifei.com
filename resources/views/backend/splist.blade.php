
    <div class="dialog container-gt" style="top: 30px;" data-dialog="dialog">
        <div class="box depth-3 cmg-mdb">
            <table class="simple-table">
                <colgroup>
                    <col width="70px">
                    <col width="150px">
                    <col width="170px">
                    <col width="40px">
                    <col width="80px">
                    <col width="120px">
                    <col width="134px">
                </colgroup>

                @if(count($sponsorsList))
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>用户名</th>
                        <th>选项</th>
                        <th>数量</th>
                        <th>总额</th>
                        <th>日期</th>
                    </tr>
                    </thead>
                    @foreach($sponsorsList as $sponsor)
                    <tbody>
                    <tr>
                        <td colspan="8"><div class="vertmg-sm">
                                <hr></div>
                        </td>
                    </tr>
                    <tr class="tr-left">
                        <td><strong class="md"># {{ substr((100000+$sponsor->order_serial), 1) }}</strong></td>
                        <td><a href="" class="redf">{{$sponsor->username}} <span class="lv pink">Lv.{{$sponsor->level}}</span></a></td>
                        <td class="grey">￥{{$sponsor->item_option_cost}} - {{$sponsor->item_option_title}}</td>
                        <td class="bold">{{$sponsor->order_amount}}</td>
                        <td class="red bold">￥{{$sponsor->order_cost}}</td>
                        <td class="grey">{{$sponsor->created_at}}</td>
                    </tr>
                    <tr><td colspan="6">
                            <div class="bgr bgr-grey">
                                <strong>手机: </strong> {{ $sponsor->phone }} - <strong>QQ:</strong> {{$sponsor->qq}} - <strong>微信:</strong> {{$sponsor->wechat}} <br>  <strong>留言:</strong> {{$sponsor->order_note}}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    @endforeach
                @else
                <tbody>
                <tr class="tr-left">
                    该项目暂无赞助
                </tr>
                </tbody>
                @endif

            </table>

            <hr>
            <ul class="bgr bgr-grey">
                @if(count($options))
                    @foreach($options as $option)
                        <li>
                            <p class="sm">￥{{$option->item_option_cost}}: {{$option->item_option_title}}@if ($option->item_option_unavailable)(该赞助选项已删除)@endif</p>
                        </li>

                    @endforeach
                @else
                暂无赞助选项
                @endif
            </ul>
            <p class="sm">请发起人按顺序联系和安排每位赞助人的游戏时间</p>
            <div class="subw">
                <button onclick="$.cancel('dialog');">关闭</button>
                <button class="red"><a href="/backend/downItemPartakeInfo/{{$itemid}}" target="_blank" style="color: #FFF;">下载赞助列表</a></button>
                <p class="sm padding-sm">筛选选项</p>
                <select name="type">
                    <option value="-2">请选择</option>
                    <option value="-1">全部</option>
                    <option value="0">无偿</option>
                    @foreach($options as $option)
                    <option value="{{$option->id}}">￥{{$option->item_option_cost}}</option>
                    @endforeach
                </select>
                <div class="pager2 fright"></div>
            </div>
        </div>
    </div>

<script>
    initSponsorList({{ $pager->page }}, {{ $pager->total  }},{{ $itemid }}, {{ $optionid }});

    {{--$(".pager2").createPage({--}}
        {{--showIndi: false,--}}
        {{--pageNum: {{ $total }},//总页码--}}
        {{--current: {{ $page }},//当前页--}}
        {{--itemid : {{ $itemid }},--}}
        {{--optionid:{{$optionid}},--}}
        {{--backfun: function(e) {--}}
            {{--var page = e.current;--}}
            {{--var json = { 'itemid': e.itemid,--}}
                {{--"optionid":e.optionid,"page":page,"limit":3};--}}
            {{--sendAjax.post(webUrl + 'sponsors', json, function(data) {--}}
                {{--$.cancel('dialog', 0);--}}
                {{--$.dialog(data);--}}

            {{--});--}}
        {{--}--}}
    {{--});--}}
    {{--$("[name=type]").val({{$optionid}});--}}
    {{--$("[name=type]").change(function(){--}}
        {{--if ($(this).val() == -2) {return;}--}}
        {{--optionid = $(this).val();--}}
        {{--var json = { 'itemid': {{ $itemid }},--}}
            {{--"optionid":$(this).val(),"page":{{ $page }},"limit":3};--}}
        {{--sendAjax.post(webUrl + 'sponsors', json, function(data) {--}}
            {{--$.cancel('dialog', 0);--}}
            {{--$.dialog(data);--}}
            {{--$("[name=type]").val(optionid);--}}
            {{--console.log(optionid);--}}
        {{--});--}}
    {{--});--}}

</script>