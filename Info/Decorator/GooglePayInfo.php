<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;

class GooglePayInfo extends Info
{
    /** @var Info */
    protected $info;

    /**
     * 是否啟用 Google Pay
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
                'ANDROIDPAY' => $this->isEnable? 1: 0,
            ];
    }
}
