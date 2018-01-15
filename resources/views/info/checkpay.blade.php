<div class="dialog depth-2 col-5" style="height: 280px;" data-dialog="dialog">
    <div class="cmg-smb">
        <div class="subw">
            <h4>订单信息</h4>
            <a href="javascript:;" class="gt fright " onclick="$.cancel('dialog');">×</a>
        </div>
        <div class="subw cmg-smr">
            <label class="sm col-2">单价 :</label>
            <p class="sm grey"> ￥{{$singleCost}}</p>
        </div>

        <div class="subw cmg-smr">
            <label class="sm col-2">选项 :</label>
            <p class="sm grey"> {{$title}}</p>
        </div>

        <div class="bgr bgr-grey cmg-smb">
            <div class="subw cmg-smr">
                <label class="col-2">支付￥ :</label>
                <strong class="md red" id="pay"> {{$cost}}</strong>
            </div>
            <div class="subw cmg-smr">
                <label class="col-2">数量 :</label>
                <p class="md"> {{$amount}}</p>
            </div>
            <div class="subw cmg-smr">
                <label class="col-2">留言 :</label>
                <p class="md"> {{$note}}</p>
            </div>
        </div>

        <div class="vertmg-md"></div>
        <h4>选择支付方式</h4>
        <div class="cmg-smr subw inner-border  inner-links">
            <a href="pay/alipay?singleCost={{$singleCost}}&amount={{$amount}}&optionid={{$optionid}}&note={{$note}}" id="alipay" class="img-sm depth-1"><img src="{{asset('images/alipay.png')}}"> 支付宝</a>
            {{--<a href="pay/wechat?" class="img-sm depth-1"><img src="images/wechat.png"> 微信</a>--}}
            <a href="javascript:;" payInfo="pay/balance?singleCost={{$singleCost}}&amount={{$amount}}&optionid={{$optionid}}&note={{$note}}" id="balancePay" class="padding-md depth-1 bg">余额: <strong id="balance">{{$balance}}</strong></a>
        </div>
    </div>
</div>
<script>
    $("#balancePay").click(function () {
        var payMoney = parseFloat($("#pay").text());
        var balanceMoney = parseFloat($("#balance").text());
        if (payMoney > balanceMoney) {
            $.loading('余额不足,充值后再试...', 2000);
            return;
        }
        $(this).attr('href',$(this).attr('payInfo'));
        $(this).trigger();
    })
</script>