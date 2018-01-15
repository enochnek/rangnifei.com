@extends('layouts/base')
@section('head')
    <style>
        body{ background-color: #333;}
    </style>
    @endsection
@section('content')

    <div class="vert-sm"></div>

    <div class="main">
        <div class="depth-3 col-8">
            <div class="padding-bg cmg-smb">
                <h3>选择项目类型和游戏</h3>
                <ul class="group box-bordergroup">
                    <li class="col-4 depth-1 active"><p class="lg">赞助赛<br><span class="grey sm"> 每日20:00结算当日赞助</span></p></li>
                    <li class="col-4 depth-1" disabled><p class="lg">挑战赛<br><span class="grey sm"> 暂时无法选择</span></p></li>
                    <li class="col-4 depth-1" disabled><p class="lg">众筹赛<br><span class="grey sm"> 暂时无法选择</span></p></li>
                </ul>

                <div class="subo fwidth inner-links" style="position: inherit;">
                    <div class="col-4 cmg-smr">
                        <a id="game" href="javascript:;" class="border" data-dropdown="click" data-id="0">选择游戏</a>
                        <span class="sm error"></span>
                        @include('widgets.gameList')
                    </div>
                    <div class="col-8 cmg-smr sub">
                        <p class="grey sm padding-tn">上传封面</p>
                        <a href="javascript:;" class="border cover-img">选择文件</a>
                    </div>
                </div>

                <div class="vertmg-sm"></div>
                <i class="hr"></i>
                <div class="vertmg-sm"></div>

                <div class="cmg-mdb">
                    <div class="cmg-tnb">
                        <p>比赛标题<span class="sm grey"> *设置比赛的标题, 不超过36个字</span> <span class="sm error"></span></p>
                        <input name="title" class="fwidth bold" type="text" placeholder="" value="">
                    </div>
                    <div class="cmg-tnb">
                        <p>规则介绍<span class="sm grey"> *比赛的简单规则介绍, 奖金介绍</span> <span class="sm error"></span></p>
                        <input name="desc" class="fwidth bold" type="text" placeholder="" value="">
                    </div>
                    <div class="cmg-tnb">
                        <p>参赛选手<span class="sm grey"> 参与比赛的主要选手, 以逗号隔开</span></p>
                        <input name="players" class="fwidth bold" type="text" placeholder="" value="">
                    </div>
                    <div class="cmg-tnb">
                        <p>直播地址<span class="sm grey"> 比赛观看网址 如 www.douyu.com/470035</span></p>
                        <input name="url" class="fwidth bold" type="text" placeholder="" value="">
                    </div>
                </div>

                <div class="vertmg-sm"></div>
                <i class="hr"></i>
                <div class="vertmg-sm"></div>

                <p>赞助选项<span class="sm grey"> 赞助者可选择的赞助选项</span></p>

                <div id="optionDiv">
                    <div class="subw">
                        <label class="vertpd-tn">选项&nbsp</label>
                        <div class="col-9 sub">
                            <input type="text" name="cost" class="col-2 bold center" placeholder="金额" maxlength="6">
                            <input type="text" name="repay" class="col-10 bold" placeholder="赞助后可以获得什么特权" maxlength="64">
                        </div>
                        <button id="addOption" class="square fa fa-plus"></button>
                        <button id="deleteOption" class="square fa fa-minus" style="display: none;"></button>
                    </div>
                </div>

                <div class="cmg-tnb">
                    <p>赞助留言<span class="sm grey"> 需要赞助人填写的留言(如联系方式/手机号等...)</span> <span class="sm error"></span></p>
                    <input name="note" class="fwidth bold" type="text" placeholder="" value="">
                </div>


                <div class="vertmg-sm"></div>
                <i class="hr"></i>
                <div class="vertmg-sm"></div>

                <div class="editor" style="background-color: #fff">
                    <div id="editorbar" class="editor-bar pin-top">
                        <button class="square" data-name="bold"><i class="fa fa-bold"></i></button>
                        <span class="greyf">|</span>
                        <button class="square" data-name="forecolor" data-value="#000"><i class="fa fa-square"></i></button>
                        <button class="square" data-name="forecolor" data-value="#888" style="color: #888;"><i class="fa fa-square"></i></button>
                        <button class="square" data-name="forecolor" data-value="#c00" style="color: #c00;"><i class="fa fa-square"></i></button>
                        <button class="square" data-name="forecolor" data-value="#00c" style="color: #00C;"><i class="fa fa-square"></i></button>
                        <span class="grey">|</span>
                        <div class="input-file oss">
                            <input type="file" id="fileElem" accept="image/jpeg, image/png, image/bmp" multiple="multiple" >
                            <button class="square"><i class="fa fa-image"></i></button>
                        </div>
                    </div>
                    <div id="editorContent" contenteditable="true"></div>
                </div>

                <button class="red fright publish vert-tn" name="save" data-type="add">发布</button>
                <div class="vertmg-sm"></div>
            </div>


        </div>
        <div class="col-4">
            <div class="offset-left depth-4">
                <img class="fwidth cover" src="" onerror='this.src="{{asset('images/default.jpg')}}"' style="height: 220px; background-image: url({{ asset('images/default.jpg') }})">
                <div class="vert-hg"></div>
            </div>
        </div>


    </div>

    <div class="vert-hg"></div>
@endsection
@section('foot')
    <script>
        uploadId = 'fileElem';
    </script>
    <script type="text/javascript" src="{{asset('js/editor.js')}}"></script>
    <script type="text/javascript" src="{{ asset('aliyunoss/lib/plupload-2.1.2/js/plupload.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('aliyunoss/upload.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/js_publish.js')}}"></script>


@endsection