<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\Constants\LanguageType;
use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Contracts\PayerInterface;
use fall1600\Package\Newebpay\Info\Decorator\Language;
use fall1600\Package\Newebpay\Info\Decorator\OfflinePay;
use fall1600\Package\Newebpay\Info\Decorator\PayComplete;
use fall1600\Package\Newebpay\Info\Decorator\PayerEmailEditable;
use fall1600\Package\Newebpay\Info\BasicInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCancel;
use fall1600\Package\Newebpay\NewebPay;
use PHPUnit\Framework\TestCase;

class InfoTest extends TestCase
{
    public function test_info()
    {
        //arrange
        $merchantId = 'merchant.id.123';

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

        //act
        $info =
            new PayComplete(
                new OfflinePay(
                    new PayCancel(
                        new Language(
                            new PayerEmailEditable(
                                new BasicInfo($order, $payer, $merchantId, $notifyUrl),
                                $email
                            ),
                            $lang = LanguageType::EN
                        ),
                        $clientBackUrl
                    ),
                    $ttl,
                    $customerUrl
                ),
                $returnUrl
            )
        ;
        $result = $info->getInfo();

        //assert
        $this->assertArrayHasKey('MerchantID', $result);
        $this->assertEquals($merchantId, $result['MerchantID']);

        $this->assertArrayHasKey('RespondType', $result);
        $this->assertEquals('JSON', $result['RespondType']);

        $this->assertArrayHasKey('TimeStamp', $result);

        $this->assertArrayHasKey('Version', $result);
        $this->assertEquals(NewebPay::VERSION, $result['Version']);

        $this->assertArrayHasKey('NotifyURL', $result);
        $this->assertEquals($notifyUrl, $result['NotifyURL']);

        $this->assertArrayHasKey('Amt', $result);
        $this->assertEquals($amt, $result['Amt']);

        $this->assertArrayHasKey('ItemDesc', $result);
        $this->assertEquals($itemDesc, $result['ItemDesc']);

        $this->assertArrayHasKey('MerchantOrderNo', $result);
        $this->assertEquals($orderMerchantNo, $result['MerchantOrderNo']);

        $this->assertArrayHasKey('Email', $result);
        $this->assertEquals($email, $result['Email']);

        $this->assertArrayHasKey('LoginType', $result);
        $this->assertEquals($loginType, $result['LoginType']);

        $this->assertArrayHasKey('EmailModify', $result);
        $this->assertEquals(1, $result['EmailModify']);

        $this->assertArrayHasKey('LangType', $result);
        $this->assertEquals($lang, $result['LangType']);

        $this->assertArrayHasKey('ClientBackURL', $result);
        $this->assertEquals($clientBackUrl, $result['ClientBackURL']);

        $this->assertArrayHasKey('ExpireDate', $result);

        $this->assertArrayHasKey('CustomerURL', $result);
        $this->assertEquals($customerUrl, $result['CustomerURL']);

        $this->assertArrayHasKey('ReturnURL', $result);
        $this->assertEquals($returnUrl, $result['ReturnURL']);
    }
}
