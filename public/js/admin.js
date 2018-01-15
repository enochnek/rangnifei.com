$("[name=pay]").click(function () {
    var settleid = $(this).data('settleid');
    var userid = $(this).data('userid');
    $.confirm('提示', '是否结算?', function() {

        $.cancel('confirm', 0);
        $.loading();


        sendAjax.post(apiUrl + 'balanceSettle', {"settleid" : settleid ,"userid":userid}, function(data) {

            if (data.status == 0) {

                $.loading('结算成功!', 1500,function () {
                    window.location.reload();
                });
            } else {
                $.loading(data.message, 1500);
            }
        });
    });
})
$("[name=delay]").click(function () {
    var settleid = $(this).data('settleid');
    var userid = $(this).data('userid');
    $.confirm('提示', '是否推迟?', function() {

        $.cancel('confirm', 0);
        $.loading();


        sendAjax.post(apiUrl + 'delay', {"settleid" : settleid ,"userid":userid}, function(data) {

            if (data.status == 0) {

                $.loading('推迟成功!', 1500,function () {
                    window.location.reload();
                });
            } else {
                $.loading(data.message, 1500);
            }
        });
    });
})

$("[name=reject]").click(function () {
    var settleid = $(this).data('settleid');
    var userid = $(this).data('userid');
    $.confirm('提示', '是否驳回?', function() {

        $.cancel('confirm', 0);
        $.loading();


        sendAjax.post(apiUrl + 'reject', {"settleid" : settleid ,"userid":userid}, function(data) {

            if (data.status == 0) {

                $.loading('驳回成功!', 1500,function () {
                    window.location.reload();
                });
            } else {
                $.loading(data.message, 1500);
            }
        });
    });
})