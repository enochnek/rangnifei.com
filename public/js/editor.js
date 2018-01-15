window.URL = window.URL || window.webkitURL;

var fileElem = document.getElementById("fileElem"),
    fileList = document.getElementById("editorContent");
var width = 614;
//var width = parseInt($(fileList).css("width"));

function handleFiles(obj) {
    var files = obj.files;


    for(var i = 0; i<files.length; i++) {
        if (files[i].size > 2048000) {
            alert("图片文件不能大于 2MB");
            return;
        }
        sel = window.getSelection();

        if (sel.rangeCount > 0) {
            var range = sel.getRangeAt(0);
        }

        var img = new Image();
        if(window.URL){
            //File API
            //alert(files[i].name + "," + files[i].size + " bytes");
            img.src = window.URL.createObjectURL(files[i]); //创建一个object URL，并不是你的本地路径

            img.width = width;
            img.onload = function(e) {
                window.URL.revokeObjectURL(this.src); //图片加载后，释放object URL
                uploader.init();
            }
            if (typeof(range) == "undefined" || range.startContainer.id != "editorContent") {
                fileList.appendChild(img);
            } else {
                range.insertNode(img);
            }

        }else if(window.FileReader){
            //opera不支持createObjectURL/revokeObjectURL方法。我们用FileReader对象来处理
            var reader = new FileReader();
            reader.readAsDataURL(files[i]);
            reader.onload = function(e){
                img.src = this.result;
                img.width = width;
                range.insertNode(img);
            }
        }else{
            //ie
            obj.select();
            obj.blur();
            var nfile = document.selection.createRange().text;
            document.selection.empty();
            img.src = nfile;
            img.width = width;
            range.insertNode(img);
        }
        if (i==files.length-1) {
            fileElem.value = "";
        }
    }
}


window.onload = function() {
    var EditDiv = {
        focus: false //確定當前焦點是否在編輯框內
    };
    document.getElementById('editorContent').onfocus = function(e) {
        EditDiv.focus = true;
    }
    document.getElementById('editorContent').onblur = function(e) {
        EditDiv.focus = false;
    }
    document.getElementById('editorContent').onkeydown = function(e) {
        var ev = e || window.event;
        var key = ev.keyCode || ev.charCode;
        var sel, rang, br, fixbr, node, inner, tempRange, offset;
        if(key == 13) {
            if(ev.preventDefault) {
                ev.preventDefault();
            } else {
                ev.returnValue = false;
            }
            if(window.getSelection) {
                if(EditDiv.focus === false) {
                    return false;
                }
                br = document.createElement('br');
                sel = window.getSelection();
                rang = sel.rangeCount > 0 ? sel.getRangeAt(0) : null;
                if (rang === null) {
                    return false;
                }
                rang.deleteContents();
                node = sel.focusNode;
                inner = false;
                while(node.parentNode != document.documentElement) {//確定focusNode是否在編輯框內
                    if(node === this) {
                        inner = true;
                        break;
                    } else {
                        node = node.parentNode;
                    }
                }
                if (inner) {
                    if(browser.chrome || browser.safari || browser.firefox) {//chrome、safari內，尾部換行時多添加一個<br type='_moz'>
                        tempRange = rang.cloneRange();
                        tempRange.selectNodeContents(this);
                        tempRange.setEnd(rang.endContainer, rang.endOffset);
                        offset = tempRange.toString().length;
                        if(offset == this.textContent.length && this.querySelectorAll("#content br[type='_moz']").length == 0) {//在行尾且不存在<br type='_moz'>時
                            fixbr = br.cloneNode();
                            fixbr.setAttribute('type', '_moz');
                            rang.insertNode(fixbr);
                        }
                    }
                    rang.insertNode(br);
                }
                if (document.implementation && document.implementation.hasFeature && document.implementation.hasFeature("Range", "2.0")) {
                    tempRange = document.createRange();
                    tempRange.selectNodeContents(this);
                    tempRange.setStart(rang.endContainer, rang.endOffset);
                    tempRange.setEnd(rang.endContainer, rang.endOffset);
                    sel.removeAllRanges();
                    sel.addRange(tempRange);
                }
            } else {
                rang = document.selection.createRange();
                if (rang === null) {
                    return false;
                }
                rang.collapse(false)
                rang.pasteHTML('<br>');
                rang.select();
            }
        }
        if($(this).find("br[type='_moz']").length>0){
            $(this).find("br").removeAttr('type');
            $(this).find("br:last").attr('type', '_moz');
        }
    }
}

//查看html片斷
function preview() {
    var htmls = document.getElementById('content').innerHTML;
    if(htmls) {
        htmls = '<div style="margin:0;padding:0;background:#bbb;">'+ htmls +'<\/div>';
        var view = window.open('about:blank', 'view');
        view.document.open();
        view.document.write(htmls);
        view.document.close();
    }
}

//判斷流覽器
(function() {
    window.browser = {};
    if(navigator.userAgent.indexOf("MSIE") > 0) {
        browser.name = 'MSIE';
        browser.ie = true;
    } else if(navigator.userAgent.indexOf("Firefox") > 0){
        browser.name = 'Firefox';
        browser.firefox = true;
    } else if(navigator.userAgent.indexOf("Chrome") > 0) {
        browser.name = 'Chrome';
        browser.chrome = true;
    } else if(navigator.userAgent.indexOf("Safari") > 0) {
        browser.name = 'Safari';
        browser.safari = true;
    } else if(navigator.userAgent.indexOf("Opera") >= 0) {
        browser.name = 'Opera';
        browser.opera = true;
    } else {
        browser.name = 'unknow';
    }
} )();

$('[contenteditable]').each(function() {
    // 干掉IE http之类地址自动加链接
    try {
        document.execCommand("AutoUrlDetect", false, false);
    } catch (e) {}

    $(this).on('paste', function(e) {
        e.preventDefault();
        var text = null;

        if(window.clipboardData && clipboardData.setData) {
            // IE
            text = window.clipboardData.getData('text');
        } else {
            text = (e.originalEvent || e).clipboardData.getData('text/plain') || prompt('在这里输入文本');
        }
        if (document.body.createTextRange) {
            if (document.selection) {
                textRange = document.selection.createRange();
            } else if (window.getSelection) {
                sel = window.getSelection();
                var range = sel.getRangeAt(0);

                // 创建临时元素，使得TextRange可以移动到正确的位置
                var tempEl = document.createElement("span");
                tempEl.innerHTML = "&#FEFF;";
                range.deleteContents();
                range.insertNode(tempEl);
                textRange = document.body.createTextRange();
                textRange.moveToElementText(tempEl);
                tempEl.parentNode.removeChild(tempEl);
            }
            textRange.text = text;
            textRange.collapse(false);
            textRange.select();
        } else {
            // Chrome之类浏览器
            document.execCommand("insertText", false, text);
        }
    });
});

(function() {
    var aCon = document.getElementById("editorbar").getElementsByTagName("button");
    for(var i = 0; i < aCon.length; i++){
        aCon[i].onclick = function(){
            document.execCommand(this.dataset.name,false,this.dataset.value);
        }
    }})();