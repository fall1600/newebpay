<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class GooglePayInfo extends EnableInfo
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ANDROIDPAY' => $this->isEnable? 1: 0,
            ];
    }
}
