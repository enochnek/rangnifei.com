@extends('layouts/base')
@section('content')
<div class="depth-10 vert-bg"></div>
<div class="depth-10">
    <div class="container-hg">
        <div class="box depth-3 cmg-mdb">
            <h2>选择赞助选项</h2>
            <div class="cmg-smb">
                @foreach($options as $option)
                <p class="md"><strong>￥{{ $option->item_option_cost }} :</strong> {{ $option->item_option_title }}</p>
                @endforeach
                <p class="grey md">若赞助自定义额度, 项目发起人可能无法进行正常安排. 建议选择发起人预设的额度</p>
            </div>
            <i class="hr"></i>
            <div>
                <h5 class="vertmg-sm red">● <span id="title">感谢您的赞助 ! </span></h5>

                <ul class="group subo cmg-smr cmg-smb">
                    @foreach($options as $option)
                        <li><a href="javascript:;" class="border-red"><strong>￥{{ $option->item_option_cost }}</strong></a></li>
                    @endforeach
                    <li class="active"><a href="javascript:;" class="border-red"><strong>自定￥</strong><input type="text" name="money" placeholder="" maxlength="6" value="1"></a></li>
                </ul>
            </div>
            <div class="subw cmg-smr">

                <p class="md vertpd-tn">数量</p>
                <div class="box-number smaller">
                    <button><i class="fa fa-minus"></i></button>
                    <input type="text" name="amount" placeholder="0" value="1">
                    <button><i class="fa fa-plus"></i></button>
                </div>
            </div>

            <div class="subw">
                <p class="md">留言 <span class="grey">{{ $note }}</span></p>
                <input type="text" name="note" placeholder="{{ $note }}" class="fwidth"></div>

            <button id="sponse" class="red">赞助</button>
        </div>
    </div>
</div>


<div class="vert-hg depth-10"></div>
@endsection
@section('foot')
    <script type="text/javascript" src="{{asset('js/js_buy.js')}}"></script>
    <script>
        webUrl = location.href;

        count = {{ count($options) }};
        @for($i = 0; $i < count($options); $i++)
            arrayTitle[{{$i}}] = "{{ $options[$i]->item_option_title }}";
            arrayCost[{{$i}}] = "{{ $options[$i]->item_option_cost }}";
            arrayOptionId[{{$i}}] = {{ $options[$i]->id }};
        @endfor
    </script>
@endsection