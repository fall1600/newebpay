<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableUnionPay extends Enable
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'UNIONPAY' => $this->isEnable ? 1 : 0,
            ];
    }
}
