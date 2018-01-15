<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - 让你飞比赛网</title>
    <meta name="keywords" content="让你飞,让你飞网,游戏赞助,比赛赞助,主播赞助,游戏主播,吃鸡比赛,LOL比赛,赞助赛">
    <meta name="describe" content="让你飞 - 游戏主播职业选手让你起飞 让你飞比赛赞助网是提供游戏主播, 官方赛事组发布比赛, 由水友和粉丝赞助的比赛平台, 提供多种多样的赛事策划, 赞助策划">
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon">
    <link href="{{asset('css/ui.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/rnf.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/animate.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="{{url('http://cdn.bootcss.com/jquery/1.12.3/jquery.min.js')}}"></script>

    @yield('head')

</head>
<body>
<div class="navbar dim">
    <div class="main inner-links">
        <ul class="sub">
            <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{{ url('/backend/publish') }}" class="blue">发布比赛</a></li>
        </ul>

        <ul class="sub fright">
            @if(session('user'))
            <li><a href="{{ url('/backend') }}" data-dropdown="hover">· {{ session('user')->username }}</a>
                <ul class="dropdown depth-10" style="right: -6px;">
                    <li><a href="{{ url('/backend/orders') }}" class="padding"><i class="fa fa-flag"></i> 我参与的</a></li>
                    <li><a href="{{ url('/backend/favorites') }}" class="padding"><i class="fa fa-heart"></i> 我关注的</a></li>
                    <li><i class="hr"></i></li>
                    <li><a href="{{ url('/backend/profile') }}" class="padding"><i class="fa fa-user"></i> 个人中心</a></li>
                    <li><a href="{{ url('/logout') }}" class="padding"><i class="fa fa-power-off"></i> 退出登录</a></li>
                </ul>
            </li>
            @else
            <li><a href="{{ url('/login') }}">登录</a></li>
            <li><a href="{{ url('/register').'/' }}@yield('inviterId')" class="red">注册</a></li>
            @endif
        </ul>
    </div>
</div>

@yield('content')

<div class="footer dim">
    <div class="main cmg-bgb">

        <div class="fwidth vertmg-sm"></div>

        <div class="col-8 box-footer">
            <div class="col-4 cmg-smb">
                <p>网站成员</p>
                <ul class="cmg-tnb">
                    <li><a href="http://www.joker1996.com" target="_blank">很皮的后台</a></li>
                    <li><a href="https://weibo.com/neccoca" target="_blank">圆圆的前端</a></li>
                    <li><a href="{{url('about/join')}}" target="_blank">加入我们</a></li>
                </ul>
            </div>
            <div class="col-4 cmg-smb">
                <p>关于网站</p>
                <ul class="cmg-tnb">
                    <li><a href="{{url('about/dimsea')}}" target="_blank">汐岛Dimsea</a></li>
                    <li><a href="{{url('about/contact')}}" target="_blank">联系方式</a></li>
                    <li><a href="{{url('about/protocol')}}" target="_blank">使用协议</a></li>
                </ul>
            </div>
            <div class="col-4 cmg-smb">
                <p>让你飞帮助</p>
                <ul class="cmg-tnb">
                    <li><a href="{{url('about/publish')}}" target="_blank">发布项目</a></li>
                    <li><a href="{{url('about/sponse')}}" target="_blank">赞助项目</a></li>
                    <li><a href="{{url('about/verifation')}}" target="_blank">用户认证</a></li>
                </ul>
            </div>
        </div>
        <div class="col-4 inner-links">
            <ul class="three padding-sm cmg-smr">
                <li><a href="https://jq.qq.com/?_wv=1027&k=5vCmtN3" class="img-lg"><img src="{{asset('images/qqQun.png')}}"><br>加入QQ群</a></li>
                <li><a href="https://weibo.com/neccoca" class="img-lg"><img src="{{asset('images/weibo.png')}}"><br>@微博</a></li>
                <li><a href="javascript:;" class="img-lg"><img src="{{asset('images/app.jpg')}}"><br>官方APP下载</a></li>
            </ul>
        </div>

        <div class="center fwidth">
            <p class="sm">©2017-2018 成都汐岛网络科技有限公司 rangnifei.com 版权所有 蜀ICP证17042634号</p>
        </div>
    </div>
</div>


</body>
<script type="text/javascript" src="{{asset('js/ui.js')}}"></script>
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dialog.js')}}"></script>

@yield('foot')
@yield('widget')
</html>