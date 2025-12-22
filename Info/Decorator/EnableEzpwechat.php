<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableEzpwechat extends Enable
{
    /**
     * 簡單付微信支付
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'EZPWECHAT' => $this->isEnable? 1: 0,
            ];
    }
}
