<?php

namespace fall1600;

use fall1600\Constants\Version;
use fall1600\Contracts\TradeInfoHashInterface;
use fall1600\Info\Info;

class NewebPay
{
    /** @var string */
    protected $urlTest = 'https://ccore.newebpay.com/MPG/mpg_gateway';

    /** @var string */
    protected $urlProduction = 'https://core.newebpay.com/MPG/mpg_gateway';

    /** @var bool */
    protected $isProduction = true;

    /** @var Info */
    protected $info;

    /** @var TradeInfoHashInterface */
    protected $tradeInfoHash;

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

        $tradeInfo = $this->tradeInfoHash->countTradeInfo($this->info);

        $tradeSha = $this->tradeInfoHash->countTradeSha($tradeInfo);

        $version = Version::CURRENT;

        return <<<EOT
        <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                </head>
                <body>
                    <form name="newebpay" id="newebpay" method="post" action={$url} style="display:none;">
                        <input type="text" name="MerchantID" value="{$this->info->getMerchantId()}" type="hidden"/>
                        <input type="text" name="Hash" value="{$tradeInfo}" type="hidden"/>
                        <input type="text" name="TradeSha" value="{$tradeSha}" type="hidden"/>
                        <input type="text" name="Version" value="{$version}" type="hidden"/>
                    </form>
                </bod>
            </html>
        EOT;
    }

    public function setInfo(Info $info)
    {
        $this->info = $info;

        return $this;
    }

    public function setTradeInfoHash(TradeInfoHashInterface $tradeInfoHash)
    {
        $this->tradeInfoHash = $tradeInfoHash;

        return $this;
    }
}
