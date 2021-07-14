<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class PayInInstallments extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /**
     * 信用卡分期付款, 可分3, 6, 12, 18, 24, 30期
     *  1: 所有分期期別
     *  3,6,12: 開啟分3, 6, 12 期
     *  0: 不開啟分期付款
     * @var string
     */
    protected $instFlag;

    public function __construct($info, $instFlag)
    {
        parent::__construct();
        $this->info = $info;

        $this->instFlag = $instFlag;
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'InstFlag' => $this->instFlag,
            ];
    }
}
