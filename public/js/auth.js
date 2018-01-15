var authUrl = "http://www.rangnifei.com/api/v1/";

var op;
var ou;
var os;
$("#resetPassword").click(function(e) {
    var phone = $("input[name=phone]").val();
    if (phone == '' || phone.length != 11 || phone[0] != '1') {
        $("#errorMsg").html("请输入正确的11位手机号码...");
        $("#errorMsg").css("display", "block");
        return;
    }

    var msgcode = $("input[name=msgcode]").val();
    if (msgcode.length != 6) {
        $("#errorMsg").html("请输入6位数验证码...");
        $("#errorMsg").css("display", "block");
        return;
    }

    var password = $("input[name=password]").val();
    if (password.length < 6 || password.length > 20) {
        $("#errorMsg").html("请输入6~20位登录密码...");
        $("#errorMsg").css("display", "block");
        return;
    }
    $.ajax({
        type:"POST",
        headers: {

        },
        url:apiUrl + 'resetPass',
        dataType:"json",
        data:{
            "phone": phone,
            "msgcode": msgcode,
            "password": password
        },
        success: function(data) {
            if (data.status == 0) {
                self.location=document.referrer;
                return;
            }

            $("#errorMsg").html(data.message);
            $("#errorMsg").css("display", "block");

        },
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});

var inviterId = 0;
$("#register").submit(function(e) {
    e.preventDefault();
    var phone = $("input[name=phone]").val();
    if (phone == '' || phone.length != 11 || phone[0] != '1') {
        $("#errorMsg").html("请输入正确的11位手机号码...");
        $("#errorMsg").css("display", "block");
        return;
    }

    var msgcode = $("input[name=msgcode]").val();
    if (msgcode.length != 6) {
        $("#errorMsg").html("请输入6位数验证码...");
        $("#errorMsg").css("display", "block");
        return;
    }

    var username = $("input[name=username]").val();
    if (username == '' || strlen(username) < 4) {
        $("#errorMsg").html("请输入4位以上用户名...");
        $("#errorMsg").css("display", "block");
        return;
    }

    var password = $("input[name=password]").val();
    if (password.length < 6 || password.length > 20) {
        $("#errorMsg").html("请输入6~20位登录密码...");
        $("#errorMsg").css("display", "block");
        return;
    }

    console.log(op+" | "+ou);

    if (op == phone || ou == username) return;

    $("#errorMsg").css("display", "none");

    $.ajax({
        type:"POST",
        headers: {

        },
        url: authUrl + 'register',
        dataType:"json",
        data:{
            "phone": phone,
            "msgcode": msgcode,
            "username": username,
            "password": password,
            "inviterId": inviterId
        },
        success: function(data) {
           
            if (data.status == 0) {
                if (data.data.redPacket == 0 || !data.data.hasOwnProperty("redPacket") ) {
                    self.location = document.referrer;
                    return;
                } else {
                    window.location.href= "http://www.rangnifei.com/packet/"+ data.data.redPacket + '/' + data.data.userid;
                }
            }

            console.log(data);
            $("#errorMsg").html(data.message);
            $("#errorMsg").css("display", "block");

            if (os == data.status) {
                if (data.status == 2) op = phone;
                if (data.status == 3) ou = username;
            } else {
                os = data.status;
                op = '';
                ou = '';
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});


$("#login").submit(function(e) {
    e.preventDefault();

    var username = $("input[name=username]").val();
    if (strlen(username).length < 4) {
        $("#errorMsg").html("请输入正确的帐号(名字或注册手机号)...");
        $("#errorMsg").css("display", "block");
        return;
    }

    var password = $("input[name=password]").val();
    if (password.length < 6 || password.length > 20) {
        $("#errorMsg").html("请输入6~20位登录密码...");
        $("#errorMsg").css("display", "block");
        return;
    }

    $("#errorMsg").css("display", "none");

    $.ajax({
        type:"POST",
        headers: {

        },
        url: authUrl + "login",
        dataType:"json",
        data:{
            "username": username,
            "password": password
        },
        success: function(data) {
            if (data.status == 0) {
                self.location=document.referrer;
                return;
            }
            $("#errorMsg").html(data.message);
            $("#errorMsg").css("display", "block");
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});


$("form a").click(function(e) {
	e.preventDefault();
	if (timer != 60) return;
    var phone = $("input[name=phone]").val();
    if (phone == '' || phone.length != 11 || phone[0] != '1') {
        $("#errorMsg").html("请输入正确的11位手机号码...");
        $("#errorMsg").css("display", "block");
        return;
    }
    $("#errorMsg").css("display", "none");
    if ($(this).attr('name') != 'reset')
        url = "register/sendRegisterSMS";
    else
        url = "resetPass/sendRegisterSMS";
    $.ajax({
        type:"POST",
        headers: {

        },
        url:authUrl + url,
        data:{
            "phone": phone
        },
        success: function(data) {
        	if (data.status != 0) {
                $("#errorMsg").html(data.message);
                $("#errorMsg").css("display", "block");
			} else {
                $("form a").attr("disabled", "disabled");
                countDown();
			}
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});

var timer = 60;
function countDown() {
    var _ = $("form a");
    _.html("已发送(" + timer + ")");
    timer--;
    if (timer < 0) {
        timer = 60;
        _.removeAttr("disabled");
        _.html("发送验证码")
    } else {
        setTimeout("countDown()", 1000);
    }
}