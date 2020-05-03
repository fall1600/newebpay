<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class AmericanExpressInfo extends EnableInfo
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CREDITAE' => $this->isEnable? 1: 0,
            ];
    }
}
