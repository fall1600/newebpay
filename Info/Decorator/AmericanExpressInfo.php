<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;

class AmericanExpressInfo extends Info
{
    /** @var Info */
    protected $info;

    /**
     * 美國運通卡啟用
     * @var bool
     */
    protected $isEnable;

    public function __construct(Info $info, bool $isEnable = true)
    {
        $this->info = $info;

        $this->isEnable = $isEnable;
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CREDITAE' => $this->isEnable? 1: 0,
            ];
    }
}