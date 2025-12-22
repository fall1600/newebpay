<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableEzpalipay extends Enable
{
    /**
     * 簡單付支付寶
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'EZPALIPAY' => $this->isEnable? 1: 0,
            ];
    }
}
