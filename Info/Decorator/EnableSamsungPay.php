<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableSamsungPay extends Enable
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'SAMSUNGPAY' => $this->isEnable? 1: 0,
            ];
    }
}
