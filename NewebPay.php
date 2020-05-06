<?php

namespace fall1600\Package\Newebpay;

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
     * 送往藍星表單的id
     * @var string
     */
    protected $formId = 'newebpay-form';

    /** @var Merchant */
    protected $merchant;

    /**
     * Hash 交易資訊用的
     * @var TradeInfoHash
     */
    protected $tradeInfoHash;

    public function checkout(Info $info)
    {
        echo $this->generateCheckoutPage($info);
    }

    /**
     * @param Info $info
     * @return string
     */
    public function generateCheckoutPage(Info $info)
    {
        return <<<EOT
        <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                </head>
                <body>
                    {$this->generateForm($info)}
                    <script>
                        var form = document.getElementById("$this->formId");
                        form.submit();
                    </script>
                </bod>
            </html>
        EOT;
    }

    /**
     * @param Info $info
     * @return string
     */
    public function generateForm(Info $info)
    {
        $url = $this->isProduction? static::URL_PRODUCTION: static::URL_TEST;

        $tradeInfo = $this->merchant->countTradeInfo($info);

        $tradeSha = $this->merchant->countTradeSha($tradeInfo);

        $version = static::VERSION;

        return <<<EOT
        <form name="newebpay" id="{$this->formId}" method="post" action={$url} style="display:none;">
            <input type="text" name="MerchantID" value="{$this->merchant->getId()}" type="hidden"/>
            <input type="text" name="TradeInfo" value="{$tradeInfo}" type="hidden"/>
            <input type="text" name="TradeSha" value="{$tradeSha}" type="hidden"/>
            <input type="text" name="Version" value="{$version}" type="hidden"/>
        </form>
        EOT;
    }

    public function setIsProduction(bool $isProduction)
    {
        $this->isProduction = $isProduction;

        return $this;
    }

    public function setFormId(string $formId)
    {
        $this->formId = $formId;

        return $this;
    }

    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;

        return $this;
    }
}
