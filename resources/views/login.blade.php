@extends('layouts/base')
@section('content')
    <div class="depth-10 vert-bg"></div>

    <div class="depth-10">
        <div class="container fadeDown">
            <div class="panel-reglog center">
                <div class="padding-bg hidden">
                    <h2 class="vertmg-tn">登录</h2>
                    <hr class="vertmg-sm">
                    <form id="login" class="subf">
                        <label for="username">用户名</label>
                        <input name="username" class="taller" type="text" placeholder="输入已注册手机号或名字...">
                        <label for="password">密码</label>
                        <input name="password" class="taller" type="password" placeholder="输入设置的密码...">
                        <input class="button red bg" type="submit" value="登录">
                    </form>
                    <a href="{{ url('/resetpass') }}" class="redf fleft bold">修改/重置密码</a>
                    <br>
                    <p id="errorMsg" class="sp red fleft"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="vert-hg depth-10"></div>

@endsection
@section('foot')
    <script type="text/javascript" src="{{asset('js/auth.js')}}"></script>
@endsection