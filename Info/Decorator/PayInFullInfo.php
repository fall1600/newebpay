<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class PayInFullInfo extends EnableInfo
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CREDIT' => $this->isEnable? 1: 0,
            ];
    }
}
