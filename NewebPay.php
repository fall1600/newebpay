<?php

namespace fall1600\Package\Newebpay;

use fall1600\Package\Newebpay\Contracts\TradeInfoEncryptInterface;
use fall1600\Package\Newebpay\Info\Info;

class NewebPay
{
    /**
     * 藍星說是哪一版就是哪一版
     * @var string
     */
    public const VERSION = '1.5';

    /**
     * 測試機網址
     * @var string
     */
    public const URL_TEST = 'https://ccore.newebpay.com/MPG/mpg_gateway';

    /**
     * 正式機網址
     * @var string
     */
    public const URL_PRODUCTION = 'https://core.newebpay.com/MPG/mpg_gateway';

    /**
     * 決定URL 要使用正式或測試機
     * @var bool
     */
    protected $isProduction = true;

    /**
     * MPG(Multi Payment Gateway) 參數
     * @var Info
     */
    protected $info;

    /**
     * 用來加密交易資訊
     * @var TradeInfoEncryptInterface
     */
    protected $tradeInfoHash;

    public function echoCheckoutPage()
    {
        echo $this->generateCheckoutPage();
    }

    /**
     * @return string
     */
    public function generateCheckoutPage()
    {
        return <<<EOT
        <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                </head>
                <body>
                    {$this->generateForm()}
                </bod>
            </html>
        EOT;
    }

    /**
     * @return string
     */
    public function generateForm()
    {
        $url = $this->isProduction? static::URL_PRODUCTION: static::URL_TEST;

        $tradeInfo = $this->tradeInfoHash->countTradeInfo($this->info);

        $tradeSha = $this->tradeInfoHash->countTradeSha($tradeInfo);

        $version = static::VERSION;

        return <<<EOT
        <form name="newebpay" id="newebpay" method="post" action={$url} style="display:none;">
            <input type="text" name="MerchantID" value="{$this->info->getMerchantId()}" type="hidden"/>
            <input type="text" name="Hash" value="{$tradeInfo}" type="hidden"/>
            <input type="text" name="TradeSha" value="{$tradeSha}" type="hidden"/>
            <input type="text" name="Version" value="{$version}" type="hidden"/>
        </form>
        EOT;
    }

    public function setInfo(Info $info)
    {
        $this->info = $info;

        return $this;
    }

    public function setTradeInfoHash(TradeInfoEncryptInterface $tradeInfoHash)
    {
        $this->tradeInfoHash = $tradeInfoHash;

        return $this;
    }

    public function setIsProduction(bool $isProduction)
    {
        $this->isProduction = $isProduction;

        return $this;
    }
}
