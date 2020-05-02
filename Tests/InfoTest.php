<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\Constants\LangType;
use fall1600\Package\Newebpay\Info\Decorator\LangInfo;
use fall1600\Package\Newebpay\Info\Decorator\OfflinePayInfo;
use fall1600\Package\Newebpay\Info\Decorator\OrderInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCompleteInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayerInfo;
use fall1600\Package\Newebpay\Info\BasicInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCancelInfo;
use fall1600\Tests\Mock\OrderMock;
use PHPUnit\Framework\TestCase;

class InfoTest extends TestCase
{
    public function test_info()
    {
        //arrange

        $merchantId = 'merchant.id.123';

        $hashKey = 'hash.key.234';

        $hashIv = 'hash.iv.345';

        $email = 'test@gg.cc';

        $returnUrl= 'return.url';

        $notifyUrl = 'notify.url';

        $clientBackUrl = 'client.back.url';

        $order = new OrderMock();

        $ttl = 3;

        $customerUrl = 'customer.url';

        $info =
            new PayCompleteInfo(
                new OfflinePayInfo(
                    new OrderInfo(
                        new PayCancelInfo(
                            new LangInfo(
                                new PayerInfo(
                                    new BasicInfo($merchantId, $notifyUrl),
                                    $email
                                ),
                            LangType::EN
                            ),
                            $clientBackUrl
                        ),
                        $order
                    ),
                    $ttl,
                    $customerUrl
                ),
                $returnUrl
            )
        ;

        //act
        var_dump($info->getInfo());

        //assert
    }
}
