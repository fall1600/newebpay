<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableVacc extends Enable
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
                'VACC' => $this->isEnable ? 1 : 0,
            ];
    }
}
