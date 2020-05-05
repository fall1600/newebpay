<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableGooglePay extends Enable
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ANDROIDPAY' => $this->isEnable? 1: 0,
            ];
    }
}
