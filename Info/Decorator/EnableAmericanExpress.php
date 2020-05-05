<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableAmericanExpress extends Enable
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CREDITAE' => $this->isEnable? 1: 0,
            ];
    }
}
