<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class OrderInfo extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /** @var OrderInterface */
    protected $order;

    public function __construct(Info $info, OrderInterface $order)
    {
        $this->info = $info;

        $this->order = $order;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'Amt' => $this->order->getAmt(),
                'ItemDesc' => $this->order->getItemDesc(),
                'MerchantOrderNo' => $this->order->getMerchantOrderNo(),
            ];
    }
}
