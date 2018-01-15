@extends('layouts/baseItem')

@section('title', '用户信息')
@section('content')

    <div class="depth-10 vert-md"></div>

    <div class="depth-10">
        <div class="container depth-1">
            <div class="box-profile padding-md">
                <img src="{{ $user->profile->avatar }}" class="avatar">
                <p class="sp"><span class="lv blove">Lv.{{ $user->level }} </span>&nbsp;&nbsp;@if($user->verification == 4)<i class="fa fa-vimeo orange"><span class="orange sp tn">主播</span></i>@endif {{ $user->username }}</p>
                <p class="md">@if($user->profile->introduction) {{ $user->profile->introduction }} @else 很惭愧，还没有填写个人说明... @endif</p>
            </div>
            <i class="hr"></i>
            <div class="padding-md">
                <p class="md"><strong>性别: </strong>@if ($user->profile->sex == 1)男@elseif($user->profile->sex == 2)女 @else 保密　@endif</p>
                <br>
                <p class="md"><strong>QQ号码: </strong>{{$user->profile->qq}}</p>
            </div>
        </div>

        <div class="vertmg-md"></div>

            <div class="main depth-1 padding-sm">
                <div class="subw padding-tn">
                    <h3>他发布的比赛({{$count}}个):</h3>
                    <i class="hr"></i>
                </div>
                @foreach($items as $item)
                <div class="col-2 padding-tn">
                    <a href="{{url('/') . '/'.  $item->id}}" target="_blank"><img src="{{ $item->item_coverurl  }}" class="offset-right vert-md fwidth"></a>
                    <div class="subw">
                    <a href="{{url('/') . '/'.  $item->id}}" class="tn red line-2" target="_blank"><strong>{{$item->item_title}}</strong></a>
                    <p class="tn grey">开始于: {{$item->created_at}}</p>
                    </div>
                </div>
                @endforeach

            </div>
    </div>

    <div class="depth-10 vert-hg"></div>
@endsection