<?php

namespace fall1600\Package\Newebpay\Tests\Mock;

use fall1600\Package\Newebpay\Contracts\AliPayPayerInterface;

class AliPayPayerMock extends PayerMock implements AliPayPayerInterface
{
    public function getReceiver()
    {
        return 'foobar';
    }

    public function getTel1()
    {
        return '0988777888';
    }

    public function getTel2()
    {
        return '0911222333';
    }
}
