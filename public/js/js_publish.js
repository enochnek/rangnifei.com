var addHtml = "<div class='subw'>\
				<label class='vertpd-tn'>选项&nbsp</label>\
				<div class='col-9 sub'>\
					<input type='text' name='cost' class='col-2 bold center' placeholder='金额' maxlength='6'>\
					<input type='text' name='repay' class='col-10 bold' placeholder='赞助后可以获得什么特权' maxlength='64'>\
				</div>\
			</div>"
var gtitle = 0,gurl = 0,gdesc = 0,gnote = 0;
$("#addOption").click(function(e) {
    e.preventDefault();
    var total = $("#optionDiv").children('div').length;
    if (total >= 5) return;

    $("#optionDiv").append(addHtml);
    $("#optionDiv > div").last().hide().fadeIn(500);

    $("#deleteOption").css("display", "block");
    $("#deleteOption").appendTo("#optionDiv > div:last");

});

$("#deleteOption").click(function(e) {
    e.preventDefault();
    var total = $("#optionDiv").children('div').length;
    if (total <= 1) return;

    if (total <= 2) {
        $("#deleteOption").appendTo("#optionDiv > div:first");
        $("#deleteOption").css("display", "none");
    }
    $("#deleteOption").appendTo($("#optionDiv > div").eq(-2));
    $("#optionDiv > div").last().fadeOut(300, function(){
        $("#optionDiv > div").last().remove();
    });

});
$(".cover-img").on('click',function(){
    $("#fileElem").click();
    uploadSuccess = function (filename) {
        url = host+ '/' + get_uploaded_object_name(filename);
        $('.fwidth').attr("src",url);
    }
})
$(".square").click(function () {
    uploadSuccess = function (filename){
        var img = document.createElement("img");
        img.src = host+ '/' + get_uploaded_object_name(filename);
        img.width = width;
        sel = window.getSelection();

        if (sel.rangeCount > 0) {
            var range = sel.getRangeAt(0);
        }
        if (typeof(range) == "undefined" || range.startContainer.id != "editorContent") {
            fileList.appendChild(img);
        } else {
            range.insertNode(img);
        }
    }
});

var err = '<span class="sm error"></span>';

$("#optionDiv").on('blur','input[name=cost]',function(){
    price = $(this).val();
    checkPrice(price) ? null : $(this).val('');
});

$(".publish").click(function () {
    $(".error").text('');


    var flag = 1;
    if(strlen($("input[name=title]").val()) > 75) {
        flag = 0;
        $("input[name=title]").siblings('p').children('span').next().html("标题超过字数限制...");
    }
    if(strlen($("input[name=title]").val()) == 0) {
        flag = 0;
        $("input[name=title]").siblings('p').children('span').next().html("标题不能为空...");
    }
    if ($("#game").attr('data-id') == 0) {
        flag = 0;
        $("#game").siblings('span').html("请选择游戏类型");
    }
    if(strlen($("input[name=desc]").val()) < 1 ) {
        flag = 0;
        $("input[name=desc]").siblings('p').children('span').next().html("规则介绍不能为空...");
    }
    if(strlen($("input[name=note]").val()) > 64){
        flag = 0;
        $("input[name=note]").siblings('p').children('span').next().html("留言超过字数限制...");
    }
    if(!flag) {$('body').animate( {scrollTop: 0}, 200);return;}
    var title =  $("[name=title]").val();
    var players = $("[name=players]").val();
    var url = $("[name=url]").val();
    var note = $("[name=note]").val();
    var gamaeid = $("#game").data('id');


    // $(strlen(title) || title.length == 0) {
    //     $("[name=title]").next
    // }

    var coverurl = $('.fwidth.cover').attr("src");
    var costArr = [];
    var contentArr = [];
    var idArr = [];

    $("[name=cost]").each(function () {
        price = $(this).val();
        if (price.length) {
            costArr.push(price);
            contentArr.push($(this).next().val());
            if ($(this).attr('option-id'))
                idArr.push($(this).attr('option-id'));
            else
                idArr.push("0");
        }

    })

    var richText = $("#editorContent")[0].innerHTML;
    richText = richText.replace(/592/g, "100%");

    var cateid = $(".box-bordergroup").children('.active').index() + 1;
    if (cateid == 0) {
        $.loading("请选择项目类型...",1500);
        return;
    }
    // if (!flag)  {
    //     $('body').animate( {scrollTop: 0}, 200);
    //     return false;
    // }

    var item_options = [];
    if (costArr.length) {
        item_options.push(costArr);
        item_options.push(contentArr);
        item_options.push(idArr);
    }
    var json = {
        "item_cataid": cateid,
        "item_gameid": gamaeid,
        "item_title": title,
        "item_players": players,
        "item_description": $("[name=desc]").val(),
        //"item_weburl": url,
        "item_weburl": autoAddHttp(url),
        "item_options": item_options,
        "item_note": note,
        "item_text": richText,
        "item_coverurl": coverurl,
    }

    $.loading("发布中...");
    type = $("[name=save]").data('type');
    if(type == "edit") {
        var backendUrl = 'edit/update';
        json["itemid"] = $("[name=save]").data('itemid');
        json["origin_ids"] = beforeIds;
        var info = "修改成功,即将跳转...";
    } else {
        var backendUrl = 'backend/createItem';
        var info = "发布成功,即将跳转...";
    }
    sendAjax.post(webUrl + backendUrl , json, function(data) {
        $.cancel('loading');
        $.loading(info, 1500, function() {
            window.location.href = '/backend/myitems';
        });
    });

})

$('[data-gameid]').click(function() {
    $('.dropdown').fadeOut(200);
    $('#game').html($(this).data('game'));
    $('#game').attr('data-id', $(this).data('gameid'));
});
