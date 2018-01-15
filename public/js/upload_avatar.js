
accessid = ''
accesskey = ''
host = ''
policyBase64 = ''
signature = ''
callbackbody = ''
filename = ''
key = ''
expire = 0
g_object_name = ''
g_object_name_type = ''
now = timestamp = Date.parse(new Date()) / 1000;
// $("#up-modal-frame").modal({});
console.log(1);
$(document).ready(function(){
        $("#up-img-touch").click(function(){
                  $("#up-modal-frame").modal({});
        });
});
$(function() {
    'use strict';
    // 初始化
    var $image = $('#up-img-show');
    $image.cropper({
        aspectRatio: '1',
        autoCropArea:0.8,
        preview: '.up-pre-after',
        responsive:true,
    });

    // 上传图片
    var $inputImage = $('.up-modal-frame .up-img-file');
    var URL = window.URL || window.webkitURL;
    var blobURL;

    if (URL) {
        $inputImage.change(function () {
            
            var files = this.files;
            var file;

            if (files && files.length) {
               file = files[0];

               if (/^image\/\w+$/.test(file.type)) {
                    blobURL = URL.createObjectURL(file);
                    $image.one('built.cropper', function () {
                        // Revoke when load complete
                       URL.revokeObjectURL(blobURL);
                    }).cropper('reset').cropper('replace', blobURL);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }
    
    //绑定上传事件
    $('.up-modal-frame .up-btn-ok').on('click',function(){

        // var $modal_loading = $('#up-modal-loading');
        var $modal_alert = $('#up-modal-alert');
        var img_src=$image.attr("src");
        if(img_src==""){
            set_alert_info("没有选择上传的图片");
            $modal_alert.modal();
            return false;
        }
        
        // $modal_loading.modal();
        var url=$(this).attr("url");

        //parameter
        var parameter=$(this).attr("parameter");
        var parame_json = eval('(' + parameter + ')');
        var width=parame_json.width;
        var height=parame_json.height;

        console.log(parame_json.width);
        console.log(parame_json.height);

        //控制裁剪图片的大小
        var canvas=$image.cropper('getCroppedCanvas',{width: width,height: height});
        var data=canvas.toDataURL(); //转成base64
        ALIcloud(convertImgDataToBlob(data));

    });
    
    $('#up-btn-left').on('click',function(){
        $("#up-img-show").cropper('rotate', 90);
    });
    $('#up-btn-right').on('click',function(){
        $("#up-img-show").cropper('rotate', -90);
    });
});


function set_alert_info(content){
    $("#alert_content").html(content);
}


function ALIcloud(file) {


    //将图片上传给阿里云服务器

    body = send_request();

    var obj = eval ("(" + body + ")");

    var ossData = new FormData();

    var filename = obj['dir'] + GenNonDuplicateID();

    ossData.append('OSSAccessKeyId', obj['accessid']);

    ossData.append('policy',obj['policy'] );

    ossData.append('signature', obj['signature']);

    ossData.append('key', filename);

    ossData.append('success_action_status', 200);

    ossData.append("file", file);

    host = obj['host'];

    $.ajax({

        url:host,

        type:'POST',

        data:ossData,

        dataType: 'xml', // 这里加个对返回内容的类型指定

        processData: false,//不需要进行序列化处理

        async: false,//发送同步请求

        contentType: false,//避免服务器不能正常解析文件

        success:function (ret) {

            avatar = host + '/' + filename;
            $("#up-modal-frame").modal('close');
            $(".am-circle").attr('src',avatar);

        },

        error: function(xhr) {


        }

    });

}

// 生成不重复随机文件名

function GenNonDuplicateID() {

    var randomStr = Number(Math.random().toString().substr(3,12) + Date.now()).toString(36);

    return randomStr.substring(0,randomStr.length - 4);

}



// 发送ajax请求,获取阿里云key

function send_request() {

    var xmlhttp = null;

    if (window.XMLHttpRequest)

    {

        xmlhttp=new XMLHttpRequest();

    }

    else if (window.ActiveXObject)

    {

        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

    }



    if (xmlhttp!=null)

    {

        serverUrl = 'http://esfeng2.dev/api/v1/getOssSign';

        xmlhttp.open( "POST", serverUrl, false );

        xmlhttp.send( null );

        return xmlhttp.responseText

    }

    else

    {

        alert("Your browser does not support XMLHTTP.");

    }

};


