
$(".input > *").focus(function() {
    $(this).parent(".input").addClass("focus");
}).blur(function() {
    $(this).parent(".input").removeClass("focus");
});


$("[data-dropdown='click']").click(function(e) {
    e.preventDefault();
    var _ = $(this);
    var list = _.siblings(".dropdown");
    if (_.hasClass("active")) {
        _.removeClass("active");
        list.fadeOut(200);
    } else {
        _.addClass("active");
        list.css("display", "block");
    }

    _.hover(null, function() {
        list.css("display", "none");
        _.removeClass("active");
    });
    list.hover(function() {
        list.css("display", "block");
        _.addClass("active");
    }, function() {
        list.fadeOut(200);
        _.removeClass("active");
    });
});

$("[data-dropdown='hover']").hover(function() {
    var _ = $(this);
    var list = _.siblings(".dropdown");
    //list.css("display", "block");
    list.fadeIn(100);
    list.hover(function() {
        list.css("display", "block");
    }, function() {
        list.fadeOut(200);
    });
}, function() {
    var list = $(this).siblings("ul.dropdown");
    list.css("display", "none");
});

// Input file
$(".input-file button").click(function() {
    var t = $(this).siblings("input[type='file']");
    t.trigger("click");
    var p = $(this).siblings("p");
    if (p[0]) {
        $(t).change(function(){
            var st = t.val().lastIndexOf("\\");
            p.text(t.val().substring(st+1));
            console.log(st);
        });
    }
});

$("[data-become]").click(function() {
    console.log('test');
    var _ = $(this).siblings('.become');
    _.css('display', 'block');
    $(this).css('display', 'none');
});



bindEvent(window,'click',delayToLoad);
function delayToLoad() {
    setTimeout(function() {
        dataInfo();
        jqGroup();
    }, 250);
}

dataInfo();
function dataInfo() {
    $("[data-info]").hover(function () {
        console.log(1);
        var _ = $(this).children(".hinfo");
        if (!_[0]) {
            return;
        }
        var p = _.parent();
        if (p.css("position") != "relative" &&
            p.css("position") != "absolute" &&
            p.css("position") != "fixed") {
            p.addClass("rela");
        }

        _.fadeIn(200);

    }, function () {
        var _ = $(this).children(".hinfo");
        _.fadeOut(100);
    });
}

// Group
jqGroup();
function jqGroup() {
    $(".group > a, .group > button, .group > li").click(function (e) {

        var _ = $(this);
        if (_.attr('disabled')) {
            return;
        }
        _.siblings(".active").removeClass("active");
        _.addClass("active");

        //_.siblings().find("i.fa-square").removeClass("fa-square").addClass("fa-square-o");
        //_.find("i.fa-square-o").removeClass("fa-square-o").addClass("fa-square");

        var p = _.parent();
        p.children().each(function () {
            if ($(this).hasClass("active")) {
                $(this).children("input[type='radio']").attr("checked", "checked");
            } else {
                $(this).children("input[type='radio']").removeAttr("checked");
            }
        });
    });
}


var imgs = document.getElementsByTagName("img");

bindEvent(window,'scroll',lazyload);
lazyload();
function lazyload(){
    forEach(imgs,function(img,i){
        if(!img || img.src ){return;}
        var t = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop ;
        var h = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        var ot=getAbsPoint(img).y;
        if( h+t<ot || t>ot+img.offsetHeight)
        {
            return;
        }
        var url = img.getAttribute("data-src");
        if(!img.src && url){
            img.src = url;
        }
    });
}

function getAbsPoint(o) {
    var x = o.offsetLeft;
    var y = o.offsetTop;
    while (o = o.offsetParent) {
        x += o.offsetLeft;
        y += o.offsetTop
    }
    return {
        'x': x,
        'y': y
    };
}
function bindEvent(obj,evt,fun)
{
    if(window.addEventListener){
        obj.addEventListener(evt, function(e){ fun(e);},false);
    }else{
        obj.attachEvent('on'+evt,fun);
    }
}
function forEach (array, callback, thisObject) {
    if (array.forEach) {
        array.forEach(callback, thisObject)
    } else {
        for (var i = 0, len = array.length; i < len; i++) {
            callback.call(thisObject, array[i], i, array)
        }
    }
};






var transData = null;
var $last = null;
function initViewurl(vid) {
$('[data-viewurl]').click(function(e){
    var storage = window.localStorage;
    var viewUrl = $(this).data('viewurl');
    url = webUrl + viewUrl;

    $last = $(this);
    var json={time:new Date().getTime()};
    history.pushState(json, '', url);

    if (storage[viewUrl+vid] && transData == null) {
        $('[data-view]').html('');
        $('[data-view]').html(storage[viewUrl+vid]);
        return;
    }

    url = webUrl + viewUrl;
    var args = transData;
    transData = null;
    sendAjax.get(url, args, function(data) {
        storage.setItem(viewUrl + vid, data);
        $('[data-view]').html('');
        $('[data-view]').html(data);
    });
});

$('[data-viewurlp]').click(function(e){
    var storage = window.localStorage;
    var viewUrl = $(this).data('viewurlp');
    url = webUrl + viewUrl;

    $last = $(this);

    var json={time:new Date().getTime()};
    history.pushState(json, '', url);

    if (storage[viewUrl+vid] && transData == null) {
        $.loading('请稍候...', 150);
        $('[data-view]').html('');
        $('[data-view]').html(storage[viewUrl+vid]);
        return;
    }

    $.loading('请稍候...');
    var args = transData;
    transData = null;
    sendAjax.post(url, args, function(data) {
        $.cancel('loading');
        storage.setItem(viewUrl + vid, data);
        $('[data-view]').html('');
        $('[data-view]').html(data);
    });
});
}

bindEvent(window, 'popstate', popBack);
function popBack() {
    var href = window.location.href;
    var dataUrl = href.substring(href.lastIndexOf('/')+1);

    $('[data-viewurlp=' + dataUrl + ']').trigger('click');
}

window.onload = function() {
    var href = window.location.href;
    var dataUrl = href.substring(href.lastIndexOf('/')+1);

    $('[data-viewurlp=' + dataUrl + ']').trigger('click');
    $('[data-viewurl=' + dataUrl + ']').trigger('click');
    delayToLoad();
};

function doAnim() {
    $('.fadeLeft').addClass('fadeInLeft animated');
    $('.fadeRight').addClass('fadeInRight animated');
    $('.fadeDown').addClass('fadeInDown animated');
    //setTimeout(removeClasses, 1000);
}


$('.fadeLeft').addClass('fadeInLeft animated');
$('.fadeRight').addClass('fadeInRight animated');
$('.fadeDown').addClass('fadeInDown animated');
//setTimeout(removeClasses, 1000);

function removeClasses() {
    $('.fadeInLeft').removeClass('fadeInLeft');
    $('.fadeInRight').removeClass('fadeInRight');
    $('.fadeInDown').removeClass('fadeInDown');
    $('.animated').removeClass('animated');
    $('.infinite').removeClass('infinite');
    $('.fadeLeft').removeClass('fadeLeft');
    $('.fadeRight').removeClass('fadeRight');
    $('.fadeDown').removeClass('fadeDown');
}



initNumber();
function initNumber() {
    $(".box-number > *").focus(function() {
        $(this).parent(".box-number").addClass("focus");
    }).blur(function() {
        $(this).parent(".box- number").removeClass("focus");
    });

    $(".box-number > *:first-child").on("click", function() {
        var c = parseInt($(this).siblings('input').val());
        if (isNaN(c)) c = 1;

        $(this).siblings('input').val(c - 1);
    });

    $(".box-number  > *:last-child").on("click", function() {
        var c = parseInt($(this).siblings('input').val());
        if (isNaN(c)) c = 0;

        $(this).siblings('input').val(c + 1);
    });
}











// Pager

(function($){

    var currentIndex = 0;

    var zp = {
        init: function(obj, pageinit) {
            zp.addhtml(obj,pageinit);
            zp.bindEvent(obj,pageinit);

        },
        addhtml: function(obj, pageinit) {
            return (function(){
                obj.empty();
                if (pageinit.shownum<5) {
                    pageinit.shownum = 5;
                }
                if (pageinit.pageNum<pageinit.shownum) {
                    pageinit.shownum = pageinit.pageNum;
                }
                var numshow = pageinit.shownum-4;
                var numbefore = parseInt((pageinit.shownum - 5)/2);
                if ((pageinit.shownum - 5)%2>0) {
                    var numafter = numbefore + 1;
                } else{
                    var numafter = numbefore;
                }
                /*上一页*/
                if (pageinit.current > 1) {
                    obj.append('<a href="javascript:;" class="pager-prev">上一页</a>');
                } else{
                    obj.remove('.prevPage');
                    obj.append('<span class="pager-prev" disabled>上一页</span>');
                }

                if (pageinit.showIndi) {
                    /*中间页*/
                    if (pageinit.current >4 && pageinit.pageNum > pageinit.shownum) {
                        obj.append('<a href="javascript:;" class="pager-indi">'+1+'</a>');
                        obj.append('<a href="javascript:;" class="pager-indi">'+2+'</a>');
                        obj.append('<span>...</span>');
                    }


                    if (pageinit.current >4 && pageinit.current < pageinit.pageNum-numshow && pageinit.pageNum > pageinit.shownum) {
                        var start = pageinit.current - numbefore,end = pageinit.current + numafter;
                    }else if(pageinit.current >4 && pageinit.current >= pageinit.pageNum-numshow && pageinit.pageNum > pageinit.shownum){
                        var start = pageinit.pageNum - numshow,end = pageinit.pageNum;
                    }else{
                        if (pageinit.pageNum <= pageinit.shownum) {
                            var start = 1,end = pageinit.shownum;
                        } else{
                            var start = 1,end = pageinit.shownum-1;
                        }
                    }
                    for (;start <= end;start++) {
                        if (start <= pageinit.pageNum && start >=1) {
                            if (start == pageinit.current) {
                                obj.append('<a href="javascript:;" class="pager-indi '+pageinit.activepage+'">'+ start +'</a>');
                            } else {
                                obj.append('<a href="javascript:;" class="pager-indi">'+ start +'</a>');
                            }
                        }
                    }
                    if (end < pageinit.pageNum) {
                        obj.append('<span>...</span>');
                    }
                }

                /*下一页*/
                if (pageinit.current >= pageinit.pageNum) {
                    obj.remove('.pager-next');
                    obj.append('<span class="pager-next" disabled>下一页</span>');
                } else{
                    obj.append('<a href="javascript:;" class="pager-next">下一页</a>');
                }
                /*尾部*/
                //obj.append('<span>'+'共'+'<b>'+pageinit.pageNum+'</b>'+'页，'+'</span>');
                obj.append('<span>'+' 跳转'+'</span>'+'<input type="text" class="pager-input" value="'+pageinit.current+'"/>'+'<span>'+' /'+pageinit.pageNum+' 页'+'</span>');
                //obj.append('<button class="pager-jumper">'+'确定'+'</button>');
            }());
        },
        bindEvent: function(obj, pageinit) {
            return (function(){
                obj.off("click");
                obj.on("click","a.pager-next",function(){
                    //var cur = parseInt(obj.children("a.active").text());
                    var current = $.extend(pageinit, {"current":++currentIndex});
                    zp.addhtml(obj,current);
                    if (typeof(pageinit.backfun)=="function") {
                        pageinit.backfun(current);
                    }
                });
                obj.on("click","a.pager-prev",function(){
                    //var cur = parseInt(obj.children("a.active").text());
                    var current = $.extend(pageinit, {"current":--currentIndex});
                    zp.addhtml(obj,current);
                    if (typeof(pageinit.backfun)=="function") {
                        pageinit.backfun(current);
                    }
                });
                obj.on("click","a.pager-indi",function(){
                    currentIndex = parseInt($(this).text());
                    var current = $.extend(pageinit, {"current":currentIndex});
                    zp.addhtml(obj,current);
                    if (typeof(pageinit.backfun)=="function") {
                        pageinit.backfun(current);
                    }
                });
                obj.on("keydown","input.pager-input",function(){
                    var inFocus;

                    console.log(obj.selector);
                    if (event.keyCode == "13") {
                        $(obj.selector + " .pager-jumper").click();

                        currentIndex = parseInt($(obj.selector + " input.pager-input").val());
                        if (currentIndex > pageinit.pageNum) currentIndex=pageinit.pageNum;
                        if (currentIndex < 1) currentIndex=1;

                        var current = $.extend(pageinit, {"current":currentIndex});
                        zp.addhtml(obj,current);
                        if (typeof(pageinit.backfun)=="function") {
                            pageinit.backfun(current);
                        }
                    }
                });
            }());
        }
    }

    $.fn.createPage = function(options) {
        var pageinit = $.extend({
            showIndi : false,
            pageNum : 15,
            current : 1,
            shownum: 9,
            activepage: "active",
            activepaf: "nextpage",
            backfun : function(){}
        }, options);

        currentIndex = pageinit.current;

        zp.init(this,pageinit);
    }
}(jQuery));