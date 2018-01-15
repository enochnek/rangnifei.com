<?php

return [
    'alipay' => [
        // 支付宝分配的 APPID
        'app_id' => '2016080301700751',

        // 支付宝异步通知地址(post)
        'notify_url' => 'http://www.rangnifei.com/api/v1/payment/alipay/asynSuccess',

        // 支付成功后同步通知地址(get)
        'return_url' => 'http://www.rangnifei.com/api/v1/payment/alipay/sychronizedSuccess',

        // 阿里公共密钥，验证签名时使用
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiG36jiVPLa/PbukpA2WnQ7IXzSSz3HmLMfcO+7AZP+x5oAnGM6Pc4s/Q9HbygdxLimTab+Jw+wFG6g0M708SYuFGQ+313ZzBmOeHJZeDiOBV0Bj7Z96pDXljOEOI7fh/kWoGWkVJzrtO1r7B/U9Nf129ZQVHL139w8VCA0mvbl67V/FhKpl2J32Vdjr5E1jHcNie/23S11Dl/G8ht8wL2Iath2K6CmJdqcYofcVYPbUmba6dzReD+ewi0Yop4Y57izjKLVGf2yVy5/khAGUMaBhZRKIYI0wSKd2lxIhbnGKehUP6BhqQRTzlQOw9D77pZ8G8jflsYAv/K4LHlfBqjQIDAQAB',

        // 自己的私钥，签名时使用
        'private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQClTSwF/AzJBmr6YBvq9ojAnncNoazqL4YqGG3z/ic/kGmjYQBub3ea3l6RPGTE4WfoZjVSEI7zqKMPYO37ZarGkgbE5YhKoUXAy5zp/X43xQ3MEAZ/aB857TcyjUQXfcOm1uqRD5ril4alsr8AKAAu1rGOF/MnoyfrXXHw0C5ArEntbNJ0pYnpAHaQvdSQUGZ3Izba7AeQKdusSh4v4uQ/VhB/8+Wo1IeObxuPO32E4IF4NUP+uGqLay8eZbN3BBEl9pCIlmitYTCRHHY5gIYWFbkioSPsgZNoS48TpzHavCwF2jumtirCY6RDw95rd+O3vbbb3OT68qdGR4AsFq4XAgMBAAECggEAIYQMMQpx7TCH8EwcXP+vqp52tSTa0oDgSxi48ofNnW3CfYXleH7RWW1M71W3eNPbJZvTo9gHpA/FQBD/L8HlZm2lQbboc3lPk0+1eRwUw2oI6h81sg+ChVQ7pNxPuhOd3+4jkVYAqYDfpCkh4P47S0PsrEre2mKSbX58477SIfp5UrB5xzRzjYSaD0vqxFkeXidCq3LUULC++PBqCOqlXK0VDkYVHRSEN5/JLnkaA0xNvMOe31p0gPGveGowJ1cG9l7iAVEzZUtWHI2b0q8diIZKgfTKmBFxoxQklW3QtJZoGHd5ZAI0rXX9/nhWqLMxfayU0nTDsw/o1PGB43DnAQKBgQDaIj5W41rM3BLragLNMHU5YQXP2+ghx6uIJzr1gzAn7OdyoYL66sFLFFQ3uyuCq13uE1yaut6EdbJ6FddAkWIdnM8TvIzck8OrshAvPLlq3s4V8zIfsDkcmZnoS8IgsJs+g6lhbWxO7KtgpZBCoriBmmxMm+VmznoT3f49RCIiEQKBgQDB/xYy+zWSAw+c9F76HVqVmLQeqOh30y9EYhW6mrrIgseqwCwcxZiHTS2GABkQV52uf8q4T9jmU95OMTaWUOsxY75eH1tL2/15AYAEZnNCN1w7TQn6RyXoT0ayJ94q22NrS6OjmMavm5BHigshFNljVK+JZsaEV45i6z8cloYlpwKBgBzsgXuf9gBIBjI1Al4W2NRc6xpevG8OPM529Thsxsvke+QVSnre+fZsoaYqKWDQPEo/Qv45XRwPRzUtBDfJj0sB6etiCwOMjFuN5tt8n9Ft7cG3V6QgB9KlA2Vr9jfDczJc3u7ORZhJhYfxLCnJzdFRmp6l5Us2gbV0sCuLh0MhAoGAfjdHqy2z4eap7tUzQgl9GR17+wKsFOHKu/QQ7RKkebZUz+wuBx4sKcN13dwMcox+o7yzGQ2iMeDZHwh32n6VNtINVlGSZZ2goWzvbG13idpY4KAz4KkPqcCCX4D+0+VfHrzcn6DTjAdrbJAMw547/Ztohb3fZNVOZ19k9WWdq7sCgYEA1r80LOVV/GliX/XaCjKmdc873QovBu32WCJiUuia4DxVt5QQFRQJ5gGofYN0Me1KEhNXGq2GJ4whjh05j2NHN2gx/jNFmrieP/QxjWVynGuSYb7DLJ/odaXei6r9bxsO2Ddfk7lneCPOE1FleZPsvmU2dlVhRmfdV664vOnCuEM=',
    ],

    'wechat' => [
        // 公众号APPID
        'app_id' => '',

        // 小程序APPID
        'miniapp_id' => '',

        // APP 引用的 appid
        'appid' => '',

        // 微信支付分配的微信商户号
        'mch_id' => '',

        // 微信支付异步通知地址
        'notify_url' => '',

        // 微信支付签名秘钥
        'key' => '',

        // 客户端证书路径，退款时需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_client' => '',

        // 客户端秘钥路径，退款时需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_key' => '',
    ],
];
