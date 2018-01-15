
<link rel="stylesheet" href="{{asset('css/amazeui.cropper.css')}}">
<link rel="stylesheet" href="{{asset('css/custom_up_img.css')}}">
<link rel="stylesheet" href="{{asset('css/amazeui.min.css')}}">

    <div class="dialog container-gt" style="top: 100px;" data-dialog="dialog">

        <div class="am-modal am-modal-no-btn up-modal-frame" tabindex="-1" id="up-modal-frame">
        <div class="am-modal-dialog up-frame-parent up-frame-radius">
        <div class="am-modal-hd up-frame-header">
        <label>修改头像</label>
        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd  up-frame-body">
        <div class="am-g am-fl">

        <div class="am-form-group am-form-file">
        <div class="am-fl">
        <button type="button" class="am-btn am-btn-default am-btn-sm">
        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
        </div>
        <input type="file" class="up-img-file">
        </div>
        </div>
        <div class="am-g am-fl">
        <div class="up-pre-before up-frame-radius">
        <img alt="" src="" class="up-img-show" id="up-img-show" >
        </div>
        <div class="up-pre-after up-frame-radius">
        </div>
        </div>
        <div class="am-g am-fl">
        <div class="up-control-btns">
        <span class="am-icon-rotate-left"   id="up-btn-left"></span>
        <span class="am-icon-rotate-right"  id="up-btn-right"></span>
        <span class="am-icon-check up-btn-ok" url="/admin/user/upload.action" parameter="{width:'100',height:'100'}">
        </span>
        </div>
        </div>

        </div>
        </div>
        </div>
    </div>

<script>


</script>
<script src="{{asset('js/amazeui.min.js')}}" charset="utf-8"></script>
<script src="{{asset('js/cropper.min.js')}}" charset="utf-8"></script>
<script src="{{asset('js/upload_avatar.js')}}"></script>