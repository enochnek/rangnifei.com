$("#front").click(function () {
    $("#fileElem").click();
    uploadSuccess = function (filename) {
        url = host+ '/' + get_uploaded_object_name(filename);
        $("#frontImg").attr("src",url);
    }
});
$("#back").click(function () {
    $("#fileElem").click();
    uploadSuccess = function (filename) {
        url = host+ '/' + get_uploaded_object_name(filename);
        $("#backImg").attr("src",url);
    }
})

$("#submit").click(function () {
    frontImg = $("#frontImg").attr('src');
    backImg = $("#backImg").attr('src');
    radioUrl = $("[name=url]").val();
    type = 4;

    if (!frontImg.length) {
        $.loading("请上传身份证正面...",1500);
        return;
    }
    if (!backImg.length) {
        $.loading("请上传身份证反面...",1500);
        return;
    }
    if (!radioUrl.length) {
        $.loading("请填写直播间地址...",1500);
        return;
    }
    if (!type) {
        $.loading("请选择认证类型...",1500);
        return;
    }
    json = {"verification":type,"radio_url":autoAddHttp(radioUrl),"back_img":backImg,"front_img":frontImg}
    sendAjax.post(apiUrl + 'verify', json, function(data) {
        if (data.status == 0) {
            $.loading("申请成功...",1500,function () {
                window.location.reload();
            });
        } else {
            $.loading(data.message,1500);
        }

    });

})