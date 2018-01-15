var arrayTitle = [];
var arrayCost = [];
var arrayOptionId = [];

var count = 0;

var singleCost = 0;
var optionId = -1;
var amount;
$('.group > li').click(function(e) {
    var index = $(this).index();

    if (index >= count) {
        $("#title").html('感谢您的赞助 ! ');
        singleCost = -1;
        optionId = -1;
    } else {
        $("#title").html(arrayTitle[index]);
        singleCost = arrayCost[index];
        optionId = arrayOptionId[index];
    }
});
$("[name=money]").on('blur',function(){
    var price = $(this).val();
    checkPrice(price) ? null : $(this).val('');
});

$("#sponse").click(function(e){

    amount = $("[name=amount]").val();
    console.log(amount);
    money = $("[name=money]").val();
    if (money != '') {
        if (money <= 0 || !checkPrice(money)) {
            $.loading('赞助金额必须为正数...',1500);
            return ;
        }
    }else {
        money = 0;
    }
    console.log(amount);
    if(amount <= 0) {
        amount = 1;
    }

    $.loading('请稍候...');
    // var href = source + '?optionid=' + optionId + "&amount=" + am + "&cost=" + cost;
    args = {"cost":singleCost,"amount":amount,
        "optionid":optionId,"note":$("[name=note]").val(),
        "money":money};
    sendAjax.post(webUrl+'/checkpay', args, function(data) {

        if (data.status == 1) {
            $.loading(data.message,2000);
            return;
        }
        $.cancel("loading", 0);
        $.dialog(data);
    });
});

