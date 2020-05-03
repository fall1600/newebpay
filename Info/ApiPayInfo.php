<?php

namespace fall1600\Package\Newebpay\Info;

use fall1600\Package\Newebpay\Contracts\AliPayPayerInterface;
use fall1600\Package\Newebpay\Contracts\OrderInterface;

abstract class ApiPayInfo extends Info
{
    public function __construct(
        OrderInterface $order,
        AliPayPayerInterface $payer,
        string $merchantId,
        string $notifyUrl
    ) {
        parent::__construct($order, $payer, $merchantId, $notifyUrl);
    }
}
