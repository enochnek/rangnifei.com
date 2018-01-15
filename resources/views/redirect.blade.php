<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>支付成功...</title>
</head>

    <div id="show"></div>

<body>
</body>


<script>
    var t = 3;//设定跳转的时间
    setInterval("refer()",1000); //启动1秒定时
    function refer() {
        if(t == 0) {
            //window.location.href = getCookie('url'); //#设定跳转的链接地址
            window.location.href = getCookie('url'); //#设定跳转的链接地址
        }
        document.getElementById('show').innerHTML="支付成功! "+t+"秒后返回前一个界面"; // 显示倒计时
        t--; // 计数器递减

    }
    function getCookie(name)
    {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    }
</script>

</html>