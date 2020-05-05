<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableCredit extends Enable
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CREDIT' => $this->isEnable? 1: 0,
            ];
    }
}
