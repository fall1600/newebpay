<?php

namespace fall1600\Package\Newebpay\Info;

use fall1600\Package\Newebpay\Contracts\AliPayPayerInterface;
use fall1600\Package\Newebpay\Contracts\OrderInterface;

abstract class AliPayInfo extends Info
{
    /**
     * 商品數量, 舉例此訂單有商品A, B兩種品項, 則帶入數值2
     * @var int $count
     */
    protected $count;

    public function __construct(
        string $merchantId,
        string $notifyUrl,
        OrderInterface $order,
        AliPayPayerInterface $payer,
        int $count
    ) {
        parent::__construct($merchantId, $notifyUrl, $order, $payer);

        $this->count = $count;
    }
}
