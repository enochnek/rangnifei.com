@extends('layouts/baseItem')

@section('title', '关于我们')
@section('content')

    <div class="depth-10 vert-md"></div>

    <div class="depth-10">
    <div class="container-gt depth-1 box box-paragraph">
        <div class="vertmg-sm"></div>

        <h3 class="center padding-md">{{ $title }}</h3>
        <p class="bgr bgr-grey"><i class="fa fa-quote-left grey"></i>  @php echo html_entity_decode($quote, ENT_QUOTES,'UTF-8')@endphp <i class="fa fa-quote-right grey"></i></p>
        <p class="padding-md">@php echo html_entity_decode($paragraph, ENT_QUOTES,'UTF-8')@endphp</p>

        <div class="vertmg-gt" data-content></div>

    </div>
    </div>

    <div class="depth-10 vert-hg"></div>
@endsection