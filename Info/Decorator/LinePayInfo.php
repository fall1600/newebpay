<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class LinePayInfo extends EnableInfo
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'LINEPAY' => $this->isEnable? 1: 0,
            ];
    }
}
