<?php

namespace fall1600\Package\Newebpay\Info\Cancel;

use fall1600\Package\Newebpay\Contracts\InfoInterface;
use fall1600\Package\Newebpay\Contracts\OrderInterface;

abstract class Info implements InfoInterface
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * 藍新金流交易序號
     * @var string|null
     */
    protected $tradeNo;

    /**
     * @param OrderInterface $order
     * @param string|null $tradeNo
     */
    public function __construct(OrderInterface $order, string $tradeNo = null)
    {
        $this->order = $order;

        $this->tradeNo = $tradeNo;
    }
}
