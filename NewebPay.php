<?php

namespace fall1600;

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

    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    public function echoPage()
    {
        echo $this->generateCheckoutPage();
    }

    /**
     * @return string
     */
    public function generateCheckoutPage(): string
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
                        <input type="text" name="TradeInfo" value="{$tradeInfo}" type="hidden"/>
                        <input type="text" name="TradeSha" value="{$tradeSha}" type="hidden"/>
                        <input type="text" name="Version" value="{$this->version}" type="hidden"/>
                    </form>
                </bod>
            </html>
        EOT;
    }


    /**
     * @return string
     */
    protected function countTradeInfo()
    {
        return $this->create_mpg_aes_encrypt(['foo' => 'bar'], $this->hashKey, $this->hashIV);
    }

    /**
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

    protected function create_mpg_aes_encrypt ($parameter = "" , $key = "", $iv = "") {
        $return_str = '';
        if (!empty($parameter)) {
//將參數經過 URL ENCODED QUERY STRING
            $return_str = http_build_query($parameter);
        }

        return trim(
            bin2hex(
                openssl_encrypt(
                    $this->addpadding($return_str),
                    'aes-256-cbc',
                    $key,
                    OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,
                    $iv)
            )
        );
    }

    protected function addpadding($string, $blocksize = 32) {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }
}
