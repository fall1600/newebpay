<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;

class PayInFullInfo extends Info
{
    /** @var Info */
    protected $info;

    /**
     * 設定是否啟用信用卡一次付清支付方式
     * @var bool
     */
    protected $isPayinfull;

    public function __construct(Info $info, bool $isPayinfull = true)
    {
        $this->info = $info;

        $this->isPayinfull = $isPayinfull;
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CREDIT' => $this->isPayinfull? 1: 0,
            ];
    }
}
