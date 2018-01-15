
function initProfileSave(sex) {

    var ointro, oqq, oavatar, owechat, osex;
    var oemail, oalipay;

    ointro = getValue($("[name=intro]").val());
    oqq = getValue($("[name=qq]").val());
    oavatar = getValue($("[name=avatar]").attr('src'));
    owechat = getValue($("[name=wechat]").val());
    osex = sex;
    oemail = getValue($("[name=email]").val());
    oalipay = getValue($("[name=alipay]").val());

    $('#profileSubmit').click(function(){
        intro = getValue($("[name=intro]").val());
        qq = getValue($("[name=qq]").val());
        avatar = $(".am-circle.avatar").attr('src');
        wechat = getValue($("[name=wechat]").val());
        email = getValue($("[name=email]").val());
        alipay = getValue($("[name=alipay]").val());

        if (intro == ointro && qq == oqq && wechat == owechat &&
            avatar == oavatar && sexIndex == osex && oemail == email && oalipay == alipay) {

            return;
        }

        ointro = intro;
        oqq = qq;
        oavatar = avatar;
        owechat = wechat;
        osex = sexIndex;
        oemail = email;
        oalipay = alipay;

        var json = {
            "introduction":intro,
            "qq":qq,
            "avatar":avatar,
            "wechat":wechat,
            'sex':sexIndex,
        };

         if (email.length > 0) {
             json['email'] = email;
         }
         if (alipay.length > 0) {
             json['alipay'] = alipay;
         }

        sendAjax.post(webUrl+'updateProfile', json, function(data) {
            if (data.status == 0)
                $.loading('更新成功!', 1500, function(data) {
                    location.reload();
                });
            else
                $.loading(data.message,1500);
        });
    });

    var sexIndex;
    $('[name=sex] li').click(function() {
        sexIndex = $('[name=sex] li').index(this);
    });


    $('.up-img-cover a').click(function() {
        $("#fileElem").click();
        console.log(uploadId);
        uploadSuccess = function (filename) {
            url = host+ '/' + get_uploaded_object_name(filename);
            $('.avatar').attr("src",url);
        }
    });

}

function initItemView() {
    $('[name=showAnnouncements]').click(function() {
        sendAjax.post(webUrl + 'announcements', { 'itemid': $(this).data('itemid') }, function(data) {

            $.dialog(data);

        });
    });

    $('[name=showSponsors]').click(function() {
        var json = { 'itemid': $(this).data('itemid'),
            "optionid":-1,"page":1,"limit":5};
        sendAjax.post(webUrl + 'sponsors', json , function(data) {

            $.dialog(data);

        });
    });
    $('[name=showSettles]').click(function() {
        var json = { 'itemid': $(this).data('itemid'),"page":1,"limit":5};
        console.log(1);

        sendAjax.post(webUrl + 'settles', json , function(data) {

            $.dialog(data);

        });
    });
}
function publishAnnouncement() {
    $("[name=publishAnnouncement]").click(function () {
        if ($("[name=private]").is(':checked'))
            var private = 1;
        else
            var private = 0;
        var json = {'itemid': $(this).data('itemid'),'item_anno_content' : $("[name=announcementContent]").val(), 'item_anno_private':private};
        sendAjax.post(webUrl + 'createAnnouncement', json, function(data) {

            if (data.status == 0) {
                $.loading("发布成功...",1500,function () {
                    location.reload();
                });

            }else{
                $.loading(data.message,1500);
            }

        });
    })

}


function initSponsorList(page, total, itemid, optionid) {
    $(".pager2").createPage({
        showIndi: false,
        pageNum: total,//总页码
        current: page,//当前页
        itemid : itemid,
        optionid: optionid,
        backfun: function(e) {

            var page = e.current;
            var json = { 'itemid': e.itemid,
                "optionid":e.optionid,"page":page,"limit": 5};

            sendAjax.post(webUrl + 'sponsors', json, function(data) {
                $.cancel('dialog', 0);
                $.dialog(data);

            });
        }
    });
    $("[name=type]").val(optionid);
    $("[name=type]").change(function(){
        if ($(this).val() == -2) {return;}
        optionid = $(this).val();
        var json = { 'itemid': itemid,
        "optionid":$(this).val(),"page":1, "limit": 5};
        sendAjax.post(webUrl + 'sponsors', json, function(data) {
            $.cancel('dialog', 0);
            $.dialog(data);
            $("[name=type]").val(optionid);
            console.log(optionid);
        });
    });

}
function initUpdate() {


    $("[name=saveStatus]").click(function () {
        if ($("[name=status]").val() == 0) return false;
        json = {"itemid":$("[name=status]").data('itemid'),"item_status": $("[name=status]").val()};
        sendAjax.post(webUrl + 'endItem', json, function(data) {
            if (data.status == 0) {
                $.loading("修改状态成功...",1500,function () {
                    location.reload();
                });
            }else {
                $.loading(data.message,1500);
            }
        });
    })
    $("[name=updateStatus]").click(function () {
        sendAjax.post(webUrl + 'showItemStatus', {'itemid':$(this).data('itemid')}, function(data) {
            $.cancel('dialog', 0);
            $.dialog(data);
        });
    })


}

