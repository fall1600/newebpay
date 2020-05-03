<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;

class CreditBonusInfo extends Info
{
    /** @var Info */
    protected $info;

    /**
     * 信用卡紅利啟用
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
                'CreditRed' => $this->isEnable? 1: 0,
            ];
    }
}
