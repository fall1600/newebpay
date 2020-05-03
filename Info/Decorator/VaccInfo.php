<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class VaccInfo extends EnableInfo
{
    /**
     * ATM 轉帳啟用
     *
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'VACC' => $this->isEnable? 1: 0,
            ];
    }
}
