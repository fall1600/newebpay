<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableCreditBonus extends Enable
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CreditRed' => $this->isEnable? 1: 0,
            ];
    }
}
