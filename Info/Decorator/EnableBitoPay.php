<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableBitoPay extends Enable
{
    /**
     * BitoPay 啟用
     *  當該筆訂單金額小於 100 元或超過 49,999元時，即使此參數設定為啟用，MPG 付款頁面仍不會顯示此支付方式選項
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'BITOPAY' => $this->isEnable? 1: 0,
            ];
    }
}
