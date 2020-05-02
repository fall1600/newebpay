<?php

namespace fall1600;

use fall1600\Info\Info;

class NewebPay
{
    /** @var string */
    protected $urlTest = 'https://ccore.newebpay.com/MPG/mpg_gateway';

    /** @var string */
    protected $urlProduction = 'https://core.newebpay.com/MPG/mpg_gateway';

    /** @var string */
    protected $version = '1.5';

    /** @var bool */
    protected $isProduction = true;

    /** @var string */
    protected $hashIV;

    /** @var string */
    protected $hashKey;

    /** @var string */
    protected $merchantID;

    /** @var Info */
    protected $info;

    public function setMerchantID(string $merchantID)
    {
        $this->merchantID = $merchantID;

        return $this;
    }
    
    public function setHashIV(string $hashIV)
    {
        $this->hashIV = $hashIV;

        return $this;
    }
    
    public function setHashKey(string $hashKey)
    {
        $this->hashKey = $hashKey;

        return $this;
    }

    public function setIsProduction(bool $isProduction)
    {
        $this->isProduction = $isProduction;

        return $this;
    }

    public function echoPage()
    {
        echo $this->generateCheckoutPage();
    }

    /**
     * @return string
     */
    public function generateCheckoutPage()
    {
        $url = $this->isProduction? $this->urlProduction: $this->urlTest;

        $tradeInfo = $this->countTradeInfo();

        $tradeSha = $this->countTradeSha($tradeInfo);

        return <<<EOT
        <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                </head>
                <body>
                    <form name="newebpay" id="newebpay" method="post" action={$url} style="display:none;">
                        <input type="text" name="MerchantID" value="{$this->merchantID}" type="hidden"/>
                        <input type="text" name="Hash" value="{$tradeInfo}" type="hidden"/>
                        <input type="text" name="TradeSha" value="{$tradeSha}" type="hidden"/>
                        <input type="text" name="Version" value="{$this->version}" type="hidden"/>
                    </form>
                </bod>
            </html>
        EOT;
    }

    /**
     * 交易資料 AES 加密
     *
     * @return string
     */
    protected function countTradeInfo()
    {
        $payload = $this->info->getInfo();

        return $this->createMpgEncrypt($payload);
    }

    /**
     * 交易資料 SHA256 加密
     *
     * @param string $tradeInfo
     * @return string
     */
    protected function countTradeSha(string $tradeInfo)
    {
        return strtoupper(
            hash(
                "sha256",
                "HashKey={$this->hashKey}&{$tradeInfo}&HashIV={$this->hashIV}"
            )
        );
    }

    protected function createMpgEncrypt ($parameter = '')
    {
        $returnStr = '';
        if (! empty($parameter)) {
            //將參數經過 URL ENCODED QUERY STRING
            $returnStr = http_build_query($parameter);
        }

        return trim(
            bin2hex(
                openssl_encrypt(
                    $this->addPadding($returnStr),
                    'aes-256-cbc',
                    $this->hashKey,
                    OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,
                    $this->hashIV)
            )
        );
    }

    protected function addPadding(string $string, int $blockSize = 32)
    {
        $len = strlen($string);
        $pad = $blockSize - ($len % $blockSize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    public function setInfo(Info $info)
    {
        $this->info = $info;

        return $this;
    }
}
