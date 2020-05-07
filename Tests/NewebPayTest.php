<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\Constants\LanguageType;
use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Contracts\PayerInterface;
use fall1600\Package\Newebpay\Info\BasicInfo;
use fall1600\Package\Newebpay\Info\Decorator\Language;
use fall1600\Package\Newebpay\Info\Decorator\OfflinePay;
use fall1600\Package\Newebpay\Info\Decorator\PayCancel;
use fall1600\Package\Newebpay\Info\Decorator\PayComplete;
use fall1600\Package\Newebpay\Info\Decorator\PayerEmailEditable;
use fall1600\Package\Newebpay\Merchant;
use fall1600\Package\Newebpay\NewebPay;
use PHPUnit\Framework\TestCase;

class NewebPayTest extends TestCase
{
    public function test_sendTransaction()
    {
        //arrange
        $newebpay = new NewebPay();

        $merchantId = 'merchant.id.123';

        $hashKey = 'hash.key.234';

        $hashIv = 'hash.iv.34567890';

//        $merchant = new Merchant($merchantId, $hashKey, $hashIv);

        $merchant = $this->getMockBuilder(Merchant::class)
            ->disableOriginalConstructor()
            ->getMock();

        $merchant->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($merchantId);

        $merchant->expects($this->once())
            ->method('countTradeInfo')
            ->willReturn($tradeInfo = '12345');

        $merchant->expects($this->once())
            ->method('countTradeSha')
            ->willReturn($tradeSha = '22345');

        $email = 'test@gg.cc';

        $returnUrl= 'return.url';

        $notifyUrl = 'notify.url';

        $clientBackUrl = 'client.back.url';

        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();

        $payer = $this->getMockBuilder(PayerInterface::class)
            ->getMock();

        $ttl = 3;

        $customerUrl = 'customer.url';

        $info = new BasicInfo($merchant->getId(), $notifyUrl, $order, $payer);
        $info = new PayerEmailEditable($info, $email);
        $info = new Language($info, LanguageType::EN);
        $info = new PayCancel($info, $clientBackUrl);
        $info = new OfflinePay($info, $customerUrl, $ttl);
        $info = new PayComplete($info, $returnUrl);

        $expected = <<<EOT
        <form name="newebpay" id="newebpay-form" method="post" action="https://ccore.newebpay.com/MPG/mpg_gateway" style="display:none;">
            <input type="text" name="MerchantID" value="{$merchantId}" type="hidden"/>
            <input type="text" name="TradeInfo" value="{$tradeInfo}" type="hidden"/>
            <input type="text" name="TradeSha" value="{$tradeSha}" type="hidden"/>
            <input type="text" name="Version" value="1.5" type="hidden"/>
        </form>
        EOT;


        //act
        $result = $newebpay
            ->setIsProduction(false)
            ->setMerchant($merchant)
            ->generateForm($info);

        //assert
        $this->assertEquals($expected, $result);
    }
}
