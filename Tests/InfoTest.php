<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\Constants\Language;
use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Contracts\PayerInterface;
use fall1600\Package\Newebpay\Info\Decorator\LanguageInfo;
use fall1600\Package\Newebpay\Info\Decorator\OfflinePayInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCompleteInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayerEmailEditableInfo;
use fall1600\Package\Newebpay\Info\BasicInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCancelInfo;
use PHPUnit\Framework\TestCase;

class InfoTest extends TestCase
{
    public function test_info()
    {
        //arrange

        $merchantId = 'merchant.id.123';

        $email = 'test@gg.cc';

        $returnUrl= 'return.url';

        $notifyUrl = 'notify.url';

        $clientBackUrl = 'client.back.url';

        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();

        $order->expects($this->once())
            ->method('getMerchantOrderNo')
            ->willReturn((string) time());

        $order->expects($this->once())
            ->method('getItemDesc')
            ->willReturn('This is an apple');

        $order->expects($this->once())
            ->method('getAmt')
            ->willReturn(100);

        $payer = $this->getMockBuilder(PayerInterface::class)
            ->getMock();

        $payer->expects($this->once())
            ->method('getEmail')
            ->willReturn('foobar@gg.cc');

        $payer->expects($this->once())
            ->method('getLoginType')
            ->willReturn(false);

        $ttl = 3;

        $customerUrl = 'customer.url';

        $info =
            new PayCompleteInfo(
                new OfflinePayInfo(
                    new PayCancelInfo(
                        new LanguageInfo(
                            new PayerEmailEditableInfo(
                                new BasicInfo($order, $payer, $merchantId, $notifyUrl),
                                $email
                            ),
                            Language::EN
                        ),
                        $clientBackUrl
                    ),
                    $ttl,
                    $customerUrl
                ),
                $returnUrl
            )
        ;

        //act
        $result = $info->getInfo();

        //assert
        $this->assertArrayHasKey('MerchantID', $result);
        $this->assertArrayHasKey('RespondType', $result);
        $this->assertArrayHasKey('TimeStamp', $result);
        $this->assertArrayHasKey('Version', $result);
        $this->assertArrayHasKey('NotifyURL', $result);
        $this->assertArrayHasKey('Amt', $result);
        $this->assertArrayHasKey('ItemDesc', $result);
        $this->assertArrayHasKey('MerchantOrderNo', $result);
        $this->assertArrayHasKey('Email', $result);
        $this->assertArrayHasKey('LoginType', $result);
        $this->assertArrayHasKey('EmailModify', $result);
        $this->assertArrayHasKey('LangType', $result);
        $this->assertArrayHasKey('ClientBackURL', $result);
        $this->assertArrayHasKey('ExpireDate', $result);
        $this->assertArrayHasKey('CustomerURL', $result);
        $this->assertArrayHasKey('ReturnURL', $result);
    }
}
