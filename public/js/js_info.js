
function initComment() {

    $("[data-commentid]").click(function() {

        var c = $('[name=comment]');
        var pla = '回复 ' + $(this).siblings('#loft').text() +
            ' ' + $(this).parent().siblings('#username').text() +
            ': ' + $(this).parent().siblings('#content').text();

        $('body').animate( {scrollTop: $('body').height()}, 200);

        c.attr('data-parent', $(this).data('commentid'));
        c.attr('placeholder', pla);
    });

}
function comment(result) {
    var content = $("[name=comment]").val();
    var parent = $("[name=comment]").data('parent');

    json = {
        "item_comment_content": content,
        "parent": parent,
        "geetest_challenge": result.geetest_challenge,
        "geetest_validate": result.geetest_validate,
        "geetest_seccode": result.geetest_seccode
    };

    sendAjax.post(webUrl + 'createComment', json, function(data) {
        if(data.status != 0) {
            $.loading(data.message, 1500);
            return;
        }
        location.reload();
    });
}
function checkCommentValid() {
    var content = $("[name=comment]").val();
    if (!$.trim(content).length) {
        $.loading('评论不能为空!', 1500);
        return false ;
    }
    return true;
}

$("[name=fav]").click(function () {
    sendAjax.post(webUrl + 'fav', null, function(data) {
        console.log(data.status);
        if (data.status===undefined || data.status) {
            $.loading('需要先登录...', 1500, function() {
                window.location.href = '/login';
            });
            return;
        }
        $("[name=unfav]").show();
        $("[name=fav]").hide();
    });
})

$("[name=unfav]").click(function () {

    $.confirm('提示', '是否取消关注?', function() {

        $.cancel('confirm', 0);
        $.loading();

        sendAjax.post(webUrl + 'unfav', null, function(data) {
            if (data.status===undefined || data.status) {

                return;
            }
            $("[name=fav]").show();
            $("[name=unfav]").hide();

            $.loading('取消成功!', 1500);
        });
    });
})
