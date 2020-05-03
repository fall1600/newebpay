<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\Info\AliPayBasicInfo;
use fall1600\Package\Newebpay\Info\Decorator\AliPayEnableInfo;
use fall1600\Package\Newebpay\Info\Decorator\AliPayProductInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayInFullInfo;
use fall1600\Package\Newebpay\Tests\Mock\AliPayPayerMock;
use fall1600\Package\Newebpay\Tests\Mock\AliPayProductMock;
use fall1600\Package\Newebpay\Tests\Mock\OrderMock;
use PHPUnit\Framework\TestCase;

class AliPayInfoTest extends TestCase
{
    public function test_getInfo()
    {
        //arrange

        $order = new OrderMock();

        $payer = new AliPayPayerMock();

        $merchantId = 'merchant.id.223';

        $notifyUrl = 'notify.url';

        $count = 3;

        $product = new AliPayProductMock();

        $info = new AliPayBasicInfo($order, $payer, $count, $merchantId, $notifyUrl);
        $info = new AliPayProductInfo($info, 1, $product);
        $info = new AliPayProductInfo($info, 2, $product);
        $info = new AliPayEnableInfo($info);
        $info = new PayInFullInfo($info);

        //act
        var_dump($info->getInfo());

        //assert
    }
}
