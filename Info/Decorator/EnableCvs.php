<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableCvs extends Enable
{
    /**
     * 超商代碼啟用
     *  若訂單金額低於30或高於 20000, 進入付款頁面也不會啟用此設定
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'CVS' => $this->isEnable? 1: 0,
            ];
    }
}
