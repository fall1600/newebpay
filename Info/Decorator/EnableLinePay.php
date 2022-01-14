<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableLinePay extends Enable
{
    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'LINEPAY' => $this->isEnable ? 1 : 0,
            ];
    }
}
