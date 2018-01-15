{{--<script src="http://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>--}}
<script src="https://static.geetest.com/static/tools/gt.js"></script>
<div id="geetest-captcha"></div>
<p id="wait" class="show">正在加载验证码...</p>
@define use Illuminate\Support\Facades\Config
<script>
    var geetest = function(url) {
        var handler = function (captchaObj) {
            captchaObj.onReady(function () {
                $("#wait").hide();
            }).onSuccess(function () {

                var result = captchaObj.getValidate();
                if (!result) {
                    $.loading('{{ Config::get('geetest.client_fail_alert')}}',1000);
                }
                comment(result);
            });
            $('#commentSubmit').click(function () {
                // 调用之前先通过前端表单校验
                if(checkCommentValid()) {
                    captchaObj.verify();
                }
            });
            // 更多接口说明请参见：http://docs.geetest.com/install/client/web-front/
        };

        $.ajax({
            url: url + "?t=" + (new Date()).getTime(),
            type: "get",
            dataType: "json",
            success: function(data) {
                initGeetest({
                    gt: data.gt,
                    challenge: data.challenge,
                    product: "{{ $product?$product:Config::get('geetest.product', 'bind') }}",
                    offline: !data.success,
                    new_captcha: data.new_captcha,
                    lang: '{{ Config::get('geetest.lang', 'zh-cn') }}',
                    http: '{{ Config::get('geetest.protocol', 'http') }}' + '://'
                }, handler);
            }
        });
    };
    (function() {
        geetest('{{ $url?$url:Config::get('geetest.url', 'geetest') }}');
    })();
</script>
<style>
    .hide {
        display: none;
    }
</style>