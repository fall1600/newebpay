<?php

namespace fall1600\Package\Newebpay\Info;

use fall1600\Package\Newebpay\Contracts\AliPayPayerInterface;
use fall1600\Package\Newebpay\Contracts\OrderInterface;

abstract class AliPayInfo extends Info
{
    /**
     * 商品項次, 舉例此訂單有商品A, B兩種品項, 則帶入數值2
     * @var int
     */
    protected $count;

    public function __construct(
        OrderInterface $order,
        AliPayPayerInterface $payer,
        int $count,
        string $merchantId,
        string $notifyUrl
    ) {
        parent::__construct($order, $payer, $merchantId, $notifyUrl);

        $this->count = $count;
    }
}
