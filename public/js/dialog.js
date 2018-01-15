
;(function ($, window, dowcument, undefined) {

    var isLoadingCancel = 0;

    func = {
        remove: function(a) { $(a).remove(); },
        fire: function(event, data) { 
            if($.isFunction(event)) { 
                return event.call(this, data); 
            } 
        },
    }

    $.extend({
        loading: function(content, maxTime, outTimeCall, html) {

            content = content != undefined ? content:'请稍候...';
            html = html != undefined ? html:loadingHtml;
            maxTime = maxTime != undefined ? maxTime:0;

            func.remove('[data-dialog="loading"]');
            $.shade();

            $('body').stop().append(html);
            $('[data-dialog="loading"]').animate({ opacity:1 }, 150);

            $('body').css('overflow', 'hidden');
            $('[data-dialog="loading"]').html(content);

            if (maxTime > 0) {
                var t = setTimeout(function() {

                    $.cancel('loading');

                    if(outTimeCall != undefined) {
                        func.fire.call(this, outTimeCall);
                    }
                }, maxTime);
            }
        },

        confirm: function(title, content, yesCall, noCall, html) {

            html = html != undefined ? html:confirmHtml;
            title = title != undefined ? title: '提示';
            content = content != undefined ? content:'确认执行该操作吗?';

            func.remove('[data-dialog="confirm"]');
            $.shade();

            $('body').stop().append(html);
            $('[data-dialog=confirm]').animate({ opacity:1 }, 150);

            $('[data-dialog=confirm] h3').html(title);
            $('[data-dialog=confirm] p').html(content);

            var ch = $('[data-dialog=confirm] p').eq(0).height();

            if (ch > 21) {
                var H = $('[data-dialog=confirm]').height();
                $('[data-dialog=confirm]').height(H+ch-21);
            }

            $('body').css('overflow', 'hidden');

            $('[data-no]').click(function() {
                $.cancel('confirm');
            });

            $('[data-yes]').click(function() {
                if(yesCall != undefined) {
                    func.fire.call(this, yesCall);
                }
            });
        },

        dialog: function(html) {

            if (html == undefined) return;

            $('body').stop().append(html);
            $.shade();
            $('[data-dialog="dialog"]').css('opacity', '0');
            $('[data-dialog="dialog"]').addClass('dialog');
            $('[data-dialog="dialog"]').animate({ opacity:1 }, 150);
            
            $('[data-no]').click(function() {
                $.cancel('confirm');
            });
        },

        shade: function() {
            if(!$(".shade").length) {
                $('body').stop().append(shadeHtml);
                $('.shade').animate({ opacity:0.3 }, 200);
            }
        },
        cancel: function(type, cancelShade) {
            if (type == undefined) return;

            cancelShade = cancelShade != undefined ? cancelShade:1;

            type = '[data-dialog='+ type +']';
            func.remove(type);

            $('body').removeAttr('style');

            if (cancelShade) {
                $('.shade').animate({ opacity: 0 }, 200, 'swing', function() {
                    func.remove('.shade');
                });
            }
        },

    });

    var dialog = {};
    window.dialog = dialog;
    dialog.loading = function(content, html) {
        $.loading(content, html);
    }
})(jQuery, window, document);

shadeHtml = '<div class="shade" style="opacity: 0.0"></div>';
loadingHtml = '<div class="loading" data-dialog="loading"></div>';
confirmHtml = '<div class="confirm" data-dialog="confirm"><div class="cmg-mdb">\
                    <h3>提示</h3>\
                    <p>确定执行该操作?</p>\
                </div>\
                <div class="fright cmg-smr">\
                    <button class="red" data-yes>确认</button>\
                    <button data-no>取消</button>\
                </div> </div>';