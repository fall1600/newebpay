<?php

namespace fall1600\Package\Newebpay\Info\Close\Decorator;

use fall1600\Package\Newebpay\Info\Close\Info;

/**
 * 取消請款或退款
 *  當傳送取消請款或退款參數時,系統將會取消該筆請款中或退款中的作業流程
 */
class Cancel extends Info
{
    /**
     * @var Info
     */
    protected $info;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }

    public function getInfo()
    {
        return $this->info->getInfo() + [
            // 取消請款或退款交易時請填 1
            'Cancel' => 1,
        ];
    }
}
