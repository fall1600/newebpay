<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableEsunwallet extends Enable
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ESUNWALLET' => $this->isEnable? 1: 0,
            ];
    }
}
