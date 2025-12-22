<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableApplePay extends Enable
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'APPLEPAY' => $this->isEnable? 1: 0,
            ];
    }
}
