<?php
/**
 * 微信支付所需参数
 */
return [
    'appid'      => 'wx2fffc402a50e03a5',                             //微信公众号appid
    'secret'     => '956397f1970f6d1b114a8ac835bc0a77',               //AppSecret
    'mch_id'     => '1439601702',                                     //微信支付商户号
    'key'        => 'def56bbd76f33932dbce862cd87d59de',               //自己设置的微信key
    'notify_url' => 'http://www.lishanlei.cn/wechatpay/wexinotify',   //异步回调地址，需外网可以访问
    'token '     => 'weixin',                                         // Token
    'level'      => 'debug',                                          //config中的log参数
    'file'       => 'storage/logs/easywechat.log',                    //config中的log参数
    'callback '  => '/examples/oauth_callback.php',                   //config中的oauth的参数
    'cert_path'  => '/var/www/SignUp/public/path/apiclient_cert.pem', //证书路径设置,绝对路径
    'key_path '  => '/var/www/SignUp/public/path/apiclient_key.pem',  //密匙文件,绝对路径
    'body'       => '三月报名费',                                      //支付后的支付订单信息
    'trade_type' => 'JSAPI',                                          //唤醒方式
    'sign_type'  => 'MD5'                                             //微信签名方式
];