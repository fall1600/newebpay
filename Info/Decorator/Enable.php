<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

abstract class Enable extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /** @var bool */
    protected $isEnable;

    public function __construct($info, $isEnable = true)
    {
        $this->info = $info;

        $this->isEnable = $isEnable;
    }
}
