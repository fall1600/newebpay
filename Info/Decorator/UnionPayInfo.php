<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class UnionPayInfo extends EnableInfo
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'UNIONPAY' => $this->isEnable? 1: 0,
            ];
    }
}
