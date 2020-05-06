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

        $merchant = new Merchant($merchantId, $hashKey, $hashIv);

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

        $info = new BasicInfo($merchant->getId(), $notifyUrl, $order, $payer);
        $info = new PayerEmailEditable($info, $email);
        $info = new Language($info, LanguageType::EN);
        $info = new PayCancel($info, $clientBackUrl);
        $info = new OfflinePay($info, $ttl, $customerUrl);
        $info = new PayComplete($info, $returnUrl);

        //act
        $newebpay
            ->setIsProduction(false)
            ->setMerchant($merchant)
            ->checkout($info);

        //assert
    }
}
