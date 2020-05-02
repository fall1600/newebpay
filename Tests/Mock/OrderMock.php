<?php

namespace fall1600\Tests\Mock;

use fall1600\Contracts\OrderInterface;

class OrderMock implements OrderInterface
{
    public function getAmt()
    {
        return 100;
    }

    public function getMerchantOrderNo()
    {
        return (string) time();
    }

    public function getItemDesc()
    {
        return 'this is an apple';
    }
}
