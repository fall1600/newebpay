<?php

namespace fall1600\Package\Newebpay\Tests\Mock;

use fall1600\Package\Newebpay\Contracts\AliPayProductInterface;

class AliPayProductMock implements AliPayProductInterface
{
    public function getProductId()
    {
        return 2234;
    }

    public function getTitle()
    {
        return 'This is an apple';
    }

    public function getDescription()
    {
        return <<<EOT
<body style="color: red">This is an apple</body>
EOT;
    }

    public function getPrice()
    {
        return 100;
    }

    public function getQuantity()
    {
        return 20;
    }
}
