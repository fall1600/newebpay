<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\Contracts\AliPayPayerInterface;
use fall1600\Package\Newebpay\Contracts\AliPayProductInterface;
use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Info\AliPayBasicInfo;
use fall1600\Package\Newebpay\Info\Decorator\AliPayEnableInfo;
use fall1600\Package\Newebpay\Info\Decorator\AliPayProductInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayInFullInfo;
use fall1600\Package\Newebpay\NewebPay;
use PHPUnit\Framework\TestCase;

class AliPayInfoTest extends TestCase
{
    public function test_getInfo()
    {
        //arrange
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

        $payer = $this->getMockBuilder(AliPayPayerInterface::class)
            ->getMock();

        $payer->expects($this->once())
            ->method('getEmail')
            ->willReturn($email = 'foobar@gg.cc');

        $payer->expects($this->once())
            ->method('getLoginType')
            ->willReturn($loginType = false);

        $payer->expects($this->once())
            ->method('getReceiver')
            ->willReturn('foobar');

        $payer->expects($this->once())
            ->method('getTel1')
            ->willReturn('0988999000');

        $payer->expects($this->once())
            ->method('getTel2')
            ->willReturn('0988777666');

        $merchantId = 'merchant.id.223';

        $notifyUrl = 'notify.url';

        $count = 3;

        $product1 = $this->getMockBuilder(AliPayProductInterface::class)
            ->getMock();

        $product1->expects($this->once())
            ->method('getProductId')
            ->willReturn($p1id = time());

        $product1->expects($this->once())
            ->method('getTitle')
            ->willReturn($p1title = 'title1');

        $product1->expects($this->once())
            ->method('getDescription')
            ->willReturn($p1desc = '<div>this is a big apple</div>');

        $product1->expects($this->once())
            ->method('getPrice')
            ->willReturn($p1price = 100);

        $product1->expects($this->once())
            ->method('getQuantity')
            ->willReturn($p1qty = 2);

        $product2 = $this->getMockBuilder(AliPayProductInterface::class)
            ->getMock();

        $product2->expects($this->once())
            ->method('getProductId')
            ->willReturn($p2id = time());

        $product2->expects($this->once())
            ->method('getTitle')
            ->willReturn($p2title = 'title2');

        $product2->expects($this->once())
            ->method('getDescription')
            ->willReturn($p2desc = '<div>this is a big camera</div>');

        $product2->expects($this->once())
            ->method('getPrice')
            ->willReturn($p2price = 1000);

        $product2->expects($this->once())
            ->method('getQuantity')
            ->willReturn($p2qty = 1);

        //act
        $info = new AliPayBasicInfo($order, $payer, $count, $merchantId, $notifyUrl);
        $info = new AliPayProductInfo($info, 1, $product1);
        $info = new AliPayProductInfo($info, 2, $product2);
        $info = new AliPayEnableInfo($info);
        $info = new PayInFullInfo($info);
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

        $this->assertArrayHasKey('Pid1', $result);
        $this->assertEquals($p1id, $result['Pid1']);

        $this->assertArrayHasKey('Title1', $result);
        $this->assertEquals($p1title, $result['Title1']);

        $this->assertArrayHasKey('Desc1', $result);
        $this->assertEquals($p1desc, $result['Desc1']);

        $this->assertArrayHasKey('Price1', $result);
        $this->assertEquals($p1price, $result['Price1']);

        $this->assertArrayHasKey('Qty1', $result);
        $this->assertEquals($p1qty, $result['Qty1']);

        $this->assertArrayHasKey('Pid2', $result);
        $this->assertEquals($p2id, $result['Pid2']);

        $this->assertArrayHasKey('Title2', $result);
        $this->assertEquals($p2title, $result['Title2']);

        $this->assertArrayHasKey('Desc2', $result);
        $this->assertEquals($p2desc, $result['Desc2']);

        $this->assertArrayHasKey('Price2', $result);
        $this->assertEquals($p2price, $result['Price2']);

        $this->assertArrayHasKey('Qty2', $result);
        $this->assertEquals($p2qty, $result['Qty2']);
    }
}
