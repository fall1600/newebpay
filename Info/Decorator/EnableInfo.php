<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;

abstract class EnableInfo extends Info
{
    /** @var Info */
    protected $info;

    /** @var bool */
    protected $isEnable;

    public function __construct(Info $info, bool $isEnable = true)
    {
        $this->info = $info;

        $this->isEnable = $isEnable;
    }
}