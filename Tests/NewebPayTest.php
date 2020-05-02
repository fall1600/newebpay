<?php

namespace fall1600\Tests;

use fall1600\Constants\LangType;
use fall1600\Info\BasicInfo;
use fall1600\Info\Decorator\LangInfo;
use fall1600\Info\Decorator\OfflinePayInfo;
use fall1600\Info\Decorator\OrderInfo;
use fall1600\Info\Decorator\PayCancelInfo;
use fall1600\Info\Decorator\PayCompleteInfo;
use fall1600\Info\Decorator\PayerInfo;
use fall1600\NewebPay;
use fall1600\Tests\Mock\OrderMock;
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

        $order = new OrderMock();

        $ttl = 3;

        $customerUrl = 'customer.url';

        $info = new BasicInfo($merchantId, $notifyUrl);
        $info = new PayerInfo($info, $email);
        $info = new LangInfo($info, LangType::EN);
        $info = new PayCancelInfo($info, $clientBackUrl);
        $info = new OrderInfo($info, $order);
        $info = new OfflinePayInfo($info, $ttl, $customerUrl);
        $info = new PayCompleteInfo($info, $returnUrl);

        $newebpay
            ->setMerchantID('MS110551869')
            ->setHashKey($hashKey)
            ->setHashIV($hashIv)
            ->setInfo($info)
            ;
        //act
        $newebpay->echoPage();

        //assert
    }
}
