<?php

namespace App\Wechat;

use WeChatPay\Builder;
use WeChatPay\Util\PemUtil;

class Pay
{
    static public function instance()
    {

        // 商户号，假定为`1000100`
        $merchantId = env("WECHATMERCHANID");
        // 商户私钥，文件路径假定为 `/path/to/merchant/apiclient_key.pem`
        $merchantPrivateKeyFilePath = base_path("pem/apiclient_key.pem");
        // 加载商户私钥
        $merchantPrivateKeyInstance = PemUtil::loadPrivateKey($merchantPrivateKeyFilePath);
        $merchantCertificateSerial = '716033821B69593A8B7F75744781ED10B8097115'; // API证书不重置，商户证书序列号就是个常量
        // // 也可以使用openssl命令行获取证书序列号
        // // openssl x509 -in /path/to/merchant/apiclient_cert.pem -noout -serial | awk -F= '{print $2}'
        // // 或者从以下代码也可以直接加载
        // // 商户证书，文件路径假定为 `/path/to/merchant/apiclient_cert.pem`
        // $merchantCertificateFilePath = base_path("pem/apiclient_cert.pem");
        // // 加载商户证书
        // $merchantCertificateInstance = PemUtil::loadCertificate($merchantCertificateFilePath);
        // // 解析商户证书序列号
        // $merchantCertificateSerial = PemUtil::parseCertificateSerialNo($merchantCertificateInstance);

        // 平台证书，可由下载器 `./bin/CertificateDownloader.php` 生成并假定保存为 `/path/to/wechatpay/cert.pem`
        $platformCertificateFilePath = base_path("pem/cert.pem");
        // 加载平台证书
        $platformCertificateInstance = PemUtil::loadCertificate($platformCertificateFilePath);
        // 解析平台证书序列号
        $platformCertificateSerial = PemUtil::parseCertificateSerialNo($platformCertificateInstance);

        // 工厂方法构造一个实例
        $instance = Builder::factory([
            'mchid' => $merchantId,
            'serial' => $merchantCertificateSerial,
            'privateKey' => $merchantPrivateKeyInstance,
            'certs' => [
                $platformCertificateSerial => $platformCertificateInstance,
            ],
            // APIv2密钥(32字节)--不使用APIv2可选
            // 'secret' => 'ZZZZZZZZZZ',// `ZZZZZZZZZZ` 为变量占位符，如需使用APIv2请替换为实际值
            // 'merchant' => [// --不使用APIv2可选
            //     // 商户证书 文件路径 --不使用APIv2可选
            //     'cert' => $merchantCertificateFilePath,
            //     // 商户API私钥 文件路径 --不使用APIv2可选
            //     'key' => $merchantPrivateKeyFilePath,
            // ],
        ]);

        return $instance;
    }
}
