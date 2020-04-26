<?php

namespace fall1600\Tests;

use fall1600\NewebPay;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class NewebPayTest extends TestCase
{
    public function test_sendTransaction()
    {
        //arrange
        $spgateway = new NewebPay(new Client());

        $spgateway
            ->setMerchantID('MS110551869')
            ->setHashKey('5orxFguQtx0ipUb0c2DOi6mbzmdOAZba')
            ->setHashIV('CCX0s59SgGIGukqP');
        //act
        $spgateway->sendTransaction();

        //assert
    }
}
