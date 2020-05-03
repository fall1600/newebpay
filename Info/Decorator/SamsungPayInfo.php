<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class SamsungPayInfo extends EnableInfo
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'SAMSUNGPAY' => $this->isEnable? 1: 0,
            ];
    }
}
