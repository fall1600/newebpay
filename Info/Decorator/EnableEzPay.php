<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableEzPay extends Enable
{
    /**
     * ezPay 電子錢包啟用
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'P2G' => $this->isEnable? 1: 0,
            ];
    }
}
