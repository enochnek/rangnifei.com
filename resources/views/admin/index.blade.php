@extends('layouts/base')
@section('content')
<div class="vert-sm depth-10"></div>

<div class="depth-10">
    <div class="main depth-1">

        <div class="box-table">
            <div class="subw">
                <label class="col-1">ID</label>
                <label class="col-3">项目</label>
                <label class="col-1">发起人</label>
                <label class="col-1">状态</label>
                <label class="col-1">结算金额</label>
                <label class="col-1">结算人数</label>
                <label class="col-2">结算时间</label>
                <label class="col-2">操作</label>
            </div>

            @if(isset($settles) && count($settles))

            @foreach($settles as $settle)

                <div class="subw">
                    <p class="col-1"><strong>{{ $settle->id }}</strong></p>
                    <a href="{{ url('/' . $settle->settle_itemid) }}" class="col-3 line red">[{{ $settle->settle_itemid }}] {{ $settle->item->item_title }}</a>
                    <a href="javascript:;" class="col-1 line red">{{ $settle->user->username }}</a>
                    <p class="col-1 @if($settle->settle_status == 0) red @endif "><strong>{{ $settle->settle_status_name }}</strong></p>
                    <p class="col-1 red"><strong>￥{{ $settle->settle_sum }}</strong></p>
                    <p class="col-1 blue"><strong>{{ $settle->settle_num }}</strong></p>
                    <p class="col-2"><strong>{{ $settle->settle_date }}</strong></p>
                    @if($settle->settle_status != 1)
                    <div class="sub col-2">
                        <a href="javascript:;" name="pay" data-settleid="{{ $settle->id }}" data-userid="{{$settle->user->id}}" class="red">结算</a>
                        <a href="javascript:;" name="delay" data-settleid="{{ $settle->id }}" data-userid="{{$settle->user->id}}" class="red">推迟</a>
                        <a href="javascript:;" name="reject" data-settleid="{{ $settle->id }}" data-userid="{{$settle->user->id}}" class="red">驳回</a>
                    </div>
                    @endif
                </div>

                @endforeach

            @endif

        </div>

    </div>
</div>
<div class="vert-hg depth-10"></div>
<script src="{{asset('js/admin.js')}}"></script>
@endsection
@section('foot')
@endsection