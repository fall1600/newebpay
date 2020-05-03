<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class BarcodeInfo extends EnableInfo
{
    /**
     * 超商條碼啟用
     *  若訂單金額小於20 或超過40000, 進入付款頁面也不會啟用此設定
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'BARCODE' => $this->isEnable? 1: 0,
            ];
    }
}
