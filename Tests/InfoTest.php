<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\Constants\Language;
use fall1600\Package\Newebpay\Info\Decorator\LanguageInfo;
use fall1600\Package\Newebpay\Info\Decorator\OfflinePayInfo;
use fall1600\Package\Newebpay\Info\Decorator\OrderInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCompleteInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayerEmailEditableInfo;
use fall1600\Package\Newebpay\Info\BasicInfo;
use fall1600\Package\Newebpay\Info\Decorator\PayCancelInfo;
use fall1600\Package\Newebpay\Tests\Mock\OrderMock;
use fall1600\Package\Newebpay\Tests\Mock\PayerMock;
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

        $payer = new PayerMock();

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
        var_dump($info->getInfo());

        //assert
    }
}
