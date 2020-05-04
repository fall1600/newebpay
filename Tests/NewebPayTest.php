<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\Constants\Language;
use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Contracts\PayerInterface;
use fall1600\Package\Newebpay\Info\BasicInfo;
use fall1600\Package\Newebpay\Info\Decorator\LanguageInfo;
use fall1600\Package\Newebpay\Info\Decorator\OfflinePayInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCancelInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCompleteInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayerEmailEditableInfo;
use fall1600\Package\Newebpay\NewebPay;
use fall1600\Package\Newebpay\TradeInfoEncrypt;
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

        $email = 'test@gg.cc';

        $returnUrl= 'return.url';

        $notifyUrl = 'notify.url';

        $clientBackUrl = 'client.back.url';

        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();

        $order->expects($this->once())
            ->method('getMerchantOrderNo')
            ->willReturn($orderMerchantNo = (string) time());

        $order->expects($this->once())
            ->method('getItemDesc')
            ->willReturn($itemDesc = 'This is an apple');

        $order->expects($this->once())
            ->method('getAmt')
            ->willReturn($amt = 100);

        $payer = $this->getMockBuilder(PayerInterface::class)
            ->getMock();

        $payer->expects($this->once())
            ->method('getEmail')
            ->willReturn($email = 'foobar@gg.cc');

        $payer->expects($this->once())
            ->method('getLoginType')
            ->willReturn($loginType = false);

        $ttl = 3;

        $customerUrl = 'customer.url';

        $info = new BasicInfo($order, $payer, $merchantId, $notifyUrl);
        $info = new PayerEmailEditableInfo($info, $email);
        $info = new LanguageInfo($info, Language::EN);
        $info = new PayCancelInfo($info, $clientBackUrl);
        $info = new OfflinePayInfo($info, $ttl, $customerUrl);
        $info = new PayCompleteInfo($info, $returnUrl);

        $newebpay
            ->setIsProduction(false)
            ->setInfo($info)
            ->setTradeInfoEncrypt(
                (new TradeInfoEncrypt())
                    ->setHashKey($hashKey)
                    ->setHashIv($hashIv)
            )
            ;
        //act
        $newebpay->echoCheckoutPage();

        //assert
    }
}
