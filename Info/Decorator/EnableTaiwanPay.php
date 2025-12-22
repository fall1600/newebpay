<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableTaiwanPay extends Enable
{
    /**
     * 台灣 Pay啟用
     *  當該筆訂單金額超過 49,999 元時，即使此參數設定為啟用，MPG 付款頁面仍不會顯示此支付方式選項
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'TAIWANPAY' => $this->isEnable ? 1 : 0,
            ];
    }
}
