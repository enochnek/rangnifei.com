<?php
/**
 * Created by PhpStorm.
 * User: Enoch - Administrator
 * Date: 2017/9/15
 * Time: 14:17
 */
return [
    'OK' => 0,
    'OK_MSG' => '成功',

    'ERROR' => 1,
    'ERROR_MSG' => '出错了,请稍候再试...',
    // Web
    'SUCCESS' => 200,
    'SUCCESS_MSG' => '成功',

    'UNAUTHORIZED' => 403,
    'UNAUTHORIZED_MSG' => '没有访问权限...',


    // Register
    'REGISTER_CODEWRONG' => 1,
    'REGISTER_CODEWRONG_MSG' => '验证码错误, 请重新输入...',

    'REGISTER_CODETIMEOUT' => 11,
    'REGISTER_CODETIMEOUT_MSG' => '验证码已过期, 请重新发送...',

    'REGISTER_PHONETAKEN' => 2,
    'REGISTER_PHONETAKEN_MSG' => '该手机号已被注册, 请更换手机号...',

    'REGISTER_USERTAKEN' => 3,
    'REGISTER_USERTAKEN_MSG' => '该名字已被注册, 换一个新名字吧...',
    'RESET_PHONE_NOT_EXIST' => 4,
    'RESET_PHONE_NOT_EXIST_MSG' => "该手机号未注册...",
    'SAME_PASSWOED' => 5,
    'SAME_PASSWOED_MSG' => "新密码与旧密码相同, 请重新输入...",

    // Login
    'LOGIN_WRONGPASS' => 1,
    'LOGIN_WRONGPASS_MSG' => '账号或密码错误, 请重新输入...',

    'LOGIN_OUTDATE' => -1,
    'LOGIN_OUTDATE_MSG' => '登录状态已过期, 请重新登录...',

    'NOT_LOGIN' => 2,
    'NOT_LOGIN_MSG' => "请登录后再试...",

    // Param
    'LACKING_PARAMS' => 1,
    'LACKING_PARAMS_MSG' => "参数不正确...",

    'PARAM_LACKING' => 1,
    'PARAM_LACKING_MSG' => '缺少参数...',

    'PARAM_ERROR' => 2,
    'PARAM_ERROR_MSG' => "参数不匹配...",

    'EMPTY' => 1,
    'EMPTY_MSG' => '未获取任何数据...',

    'DB_ERROR' => 2,
    'DB_ERROR_MSG' => "数据库操作失败...",

    'ID_NONE' => 3,
    'ID_NONE_MSG' => '该ID不存在...',

    // Pay
    'PAY_SIGNFAILED' => 1,
    'PAY_SIGNFAILED_MSG' => '签名不匹配...',
    'IS_FAKE' => 1,
    'IS_FAKE_MSG' => "该项目暂不能赞助...",
    'PAY_INT' => 2,
    'PAY_INT_MSG' => "赞助金额必须为正数...",

    // Update User Profile
    'NICKNAME_MIN' => 1,
    'NICKNAME_MAX' => 2,
    'INTR_MAX'     => 3,
    'AVATAR_MAX'   => 4,
    'BIRTHDAY_RULE'=> 5,
    'ADDRESS_RULE' => 6,
    'QQ_MIN'       => 7,
    'QQ_MAX'       => 8,
    'WECHAT_MIN'   => 9,
    'WECHAT_MAX'   => 10,
    'EMAIL' => 11,
    'NICKNAME_MIN_MSG' => "昵称不能少于6个字符",
    'NICKNAME_MAX_MSG' => "昵称不能少于大于20个字符",
    'INTR_MAX_MSG'     => "介绍不能大于255个字符",
    'AVATAR_MAX_MSG'   => "头像地址不能大于255个字符",
    'BIRTHDAY_RULE_MSG'=> "生日格式只能为严格的时间格式 xxxx-xx-xx xx:xx:xx",
    'ADDRESS_RULE_MSG' => "地址信息不能大于255个字符",
    'QQ_MIN_MSG'       => "QQ不能小于5个数字",
    'QQ_MAX_MSG'       => "QQ不能大于11个数字",
    'WECHAT_MIN_MSG'   => "微信号不能小于5个字符",
    'WECHAT_MAX_MSG'   => "微信号不能大于30个字符",
    'EMAIL_MSG'        => "邮箱格式不正确...",


    // Comment Validate
    'GEETEST_ERROR' => "1",
    'GEETEST_ERROR_MSG' => "验证未通过...",
    'COMMENT_NOT_PAY' => 1,
    'COMMENT_NOT_PAY_MSG' => "未赞助项目不可评论...",

    'COMMENT_LIMIT' => 1,
    'COMMENT_LIMIT_MSG' => "最大评论5次...",

    // Item End Status Cd

    'ITEM_NOT_UPDATE_STATUS' => 1,
    'ITEM_NOT_UPDATE_STATUS_MSG' => '三天后再试...',

    'ITEM_UPDATE_END_STATUS' => 2,
    'ITEM_UPDATE_END_STATUS_MSG' => "暂无法进行该操作...",
    'ITEM_PARTAKE_STATUS' => 3,
    'ITEM_PARTAKE_STATUS_MSG' => "暂无法进行该操作...",
    'ITEM_COMPLETE_STATUS' => 4,
    'ITEM_COMPLETE_STATUS_MSG' => "暂无法进行该操作...",
    'ITEM_PAUSE_STATUS' => 5,
    'ITEM_PAUSE_STATUS_MSG' => "暂无法进行该操作...",
    'ITEM_SEASON_STATUS' => 6,
    'ITEM_SEASON_STATUS_MSG' => "暂无法进行该操作...",
    'ITEM_AUDIT_STATUS' => 7,
    'ITEM_AUDIT_STATUS_MSG'=> "审核中不能修改状态...",
    'ITEM_SETTLE' =>    8,
    'ITEM_SETTLE_MSG' => "项目未结算完毕...",

    // Verity
    'EXIST_VERIFY' => 1,
    'EXIST_VERIFY_MSG' => "请勿重复提交认证...",

    // announcement

    'ANNOUNCEMENT_CD_CODE' => 1,
    'ANNOUNCEMENT_CD_CODE_MSG' => "不能频繁发布公告...",




];



