<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class LogisticsInfo extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /**
     * 1: 超商取貨不付款
     * 2: 超商取貨付款
     * 3: 超商取貨不付款及超商取貨付款 (1,2同時)
     * 0: 不啟用
     *  若訂單金額小於30 或大於20000, 進入付款頁面不顯示此支付方式
     * @var int
     */
    protected $type;

    public function __construct(Info $info, int $type)
    {
        $this->info = $info;

        $this->setType($type);
    }

    /**
     * 物流啟用
     *
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CVSCOM' => $this->type,
            ];
    }

    /**
     * @param int $type
     */
    protected function setType(int $type)
    {
        if ($type < 0 || $type > 3) {
            throw new \LogicException('Newebpay does not support this type');
        }

        $this->type = $type;
    }
}
