<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class WebAtmInfo extends EnableInfo
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'WEBATM' => $this->isEnable? 1: 0,
            ];
    }
}