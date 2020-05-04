<?php

namespace fall1600\Package\Newebpay\Tests;

use fall1600\Package\Newebpay\TradeInfoDecrypt;
use PHPUnit\Framework\TestCase;

class TradeInfoDecryptTest extends TestCase
{
    public function test_decrypt()
    {
        //arrange
        $decrypt = new TradeInfoDecrypt();
        $decrypt->setHashKey($hashKey = '12345678901234567890123456789012')
            ->setHashIv($hashIv = '1234567890123456');

        $encryptedStr = 'ff91c8aa01379e4de621a44e5f11f72e4d25bdb1a18242db6cef9ef07d80b0165e476fd1d9acaa53170272c82d122961e1a0700a7427cfa1cf90db7f6d6593bbc93102a4d4b9b66d9974c13c31a7ab4bba1d4e0790f0cbbbd7ad64c6d3c8012a601ceaa808bff70f94a8efa5a4f984b9d41304ffd879612177c622f75f4214fa';

        $expected = 'MerchantID=3430112&RespondType=JSON&TimeStamp=1485232229&Version=1.4&MerchantOrderNo=S_1485232229&Amt=40&ItemDesc=UnitTest';

        //act
        $result = $decrypt->createAesDecrypt($encryptedStr);

        //assert
        $this->assertEquals($expected, $result);
    }
}
