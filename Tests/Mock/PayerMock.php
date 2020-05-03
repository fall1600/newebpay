<?php

namespace fall1600\Package\Newebpay\Tests\Mock;

use fall1600\Package\Newebpay\Contracts\PayerInterface;

class PayerMock implements PayerInterface
{
    public function getEmail()
    {
        return 'foobar@gg.cc';
    }

    public function getLoginType()
    {
        return false;
    }
}
