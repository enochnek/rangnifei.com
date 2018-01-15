
var uploadId = null;
var uploadSuccess = null;
var getUploadFileSetInfo = 'http://www.rangnifei.com/api/v1/getOssSign';
webUrl = "http://www.rangnifei.com/";
apiUrl = "http://www.rangnifei.com/api/v1/";

sendAjax = {

	post: function(url, data, sucCall, errCall) {
		this.ajax('POST', url, data, sucCall) 
	},

	get: function(url, data, sucCall, errCall) {
		this.ajax('GET', url, data, sucCall) 
	},

	getView: function(url, data, selector) {
		this.ajax('GET', url, data, function(data) {
			$(selector).html(data);
		});
	}, 

	ajax: function(type, url, data, sucCall, errCall) {

		//data = JSON.stringify(data);
		console.log(url);

		$.ajax({
			type: type,
			url: url,
			data: data,
			success: function(data) {
				if (sucCall != undefined) {
                    sucCall.call(this, data);
				}
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);

				if(errCall != undefined) {
                    errCall.call(this, xhr);
                }
			}
		});
	},
}

//cacher();
function cacher(key, value) {
    var storage = window.localStorage;

    if (key === undefined) {
    	storage.clear();
    	return;
	}

    if (value != undefined) {
        return storage.setItem(key, value);
	} else {
		return storage[key];
	}
}
function removeCache(key, backfix) {
    var storage = window.localStorage;
	
	if (key === undefined) {
		var length = $("[data-viewurl]").length;
		var length2 = $("[data-viewurlp]").length;
		for(var i=0; i<length; i++) {
			var viewurl = $("[data-viewurl]").eq(i).data('viewurl');
			storage.removeItem(viewurl+backfix);
		}
		for(var i=0; i<length2; i++) {
			var viewurl = $("[data-viewurlp]").eq(i).data('viewurlp');
			storage.removeItem(viewurl+backfix);
		}
	} else {
		storage.removeItem(key);
	}
	return true;
}

function getPrefixNum(num, length, prefix) {
	prefix = prefix != undefined ? prefix:0;
	return (Array(length).join(prefix) + num).slice(-length);
}

function toMoney(num) {  
    var num = (num || 0).toString(), result = '';  
    while (num.length > 3) {  
        result = ',' + num.slice(-3) + result;  
        num = num.slice(0, num.length - 3);  
    }  
    if (num) { result = num + result; }

    result = result.replace(',.', '.');
    return result;  
}

function strlen(str) {  
	var len = 0;  
	for (var i = 0; i < str.length; i++) {
		var c = str.charCodeAt(i);
		if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
			len++;
		} else {
			len+=2;
		}   
    }   
    return len;  
}

function replaceIndex(str, start, end, replace) {
	replace = replace != undefined ? replace : '*';
	end = end != undefined ? end : str.last();

	var temp = str.substring(start, end);

	var rep = '';
	for(var i=0; i<end-start; i++) {
		rep += replace;
	}
	return str.replace(temp, rep);
}

function getValue(origin, def) {
	def = def !== undefined ? def: '';

	if (origin && origin.length) {
		//console.log('origin:' + origin);
		return origin;
	}
    //console.log('def:' + def);
	return def;
}
function getUrlFirstFileParam()
{
    var url=window.location.href;//获取完整URL
    var tmp= new Array();//临时变量，保存分割字符串
    tmp=url.split("/");//按照"/"分割
    var pp = tmp[tmp.length-1];//获取最后一部分，即文件名和参数
    tmp=pp.split("?");//把参数和文件名分割开
    return tmp[0];
}

/**
 * 验证金额
 * @author StubbornGrass
 * @dateTime 2017-11-02
 * @param    {[mixed]}   money 	 [任意数据类型]
 * @return   {[Boolean]}         [验证通过返回true,反之false]
 */
function checkPrice(money) {
    var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
    //000 错
    //0 对
    //0. 错
    //0.0 对
    //050 错
    //00050.12错
    //70.1 对
    //70.11 对
    //70.111错
    //500 正确
    if (reg.test(money)) {
        return true;
    } else {
        return false;
    };

}
/**
 * 验证值是否为数字
 * @author StubbornGrass
 * @dateTime 2017-11-02
 * @param    {[mixed]}   value [任意数据类型]
 * @return   {[Boolean]}       [验证通过返回true,反之false]
 */
function validate(value) {
    var reg = new RegExp("^[0-9]*$");
    if(!reg.test(value)) {
        return false;
    }
    return true;
}

// base64编码对象转blob二进制

function convertImgDataToBlob(base64Data) {

    var format = "image/jpeg";

    var base64 = base64Data;

    var code = window.atob(base64.split(",")[1]);

    var aBuffer = new window.ArrayBuffer(code.length);

    var uBuffer = new window.Uint8Array(aBuffer);

    for(var i = 0; i < code.length; i++){

        uBuffer[i] = code.charCodeAt(i) & 0xff ;

    }

    console.info([aBuffer]);

    console.info(uBuffer);

    console.info(uBuffer.buffer);

    console.info(uBuffer.buffer==aBuffer); //true



    var blob=null;

    try{

        blob = new Blob([uBuffer], {type : format});

    }

    catch(e){

        window.BlobBuilder = window.BlobBuilder ||

            window.WebKitBlobBuilder ||

            window.MozBlobBuilder ||

            window.MSBlobBuilder;

        if(e.name == 'TypeError' && window.BlobBuilder){

            var bb = new window.BlobBuilder();

            bb.append(uBuffer.buffer);

            blob = bb.getBlob("image/jpeg");



        }

        else if(e.name == "InvalidStateError"){

            blob = new Blob([aBuffer], {type : format});

        }

        else{



        }

    }

    // alert(blob.size);

    return blob;



};

function autoAddHttp(url) {
    var regex = /(https?:\/\/)?(\w+\.?)+(\/[a-zA-Z0-9\?%=_\-\+\/]+)?/gi;

    url = url.replace(regex, function (match, capture) {
        if (capture) {
            return match
        }
        else {
            return 'http://' + match;
        }
    });
    return url;
}