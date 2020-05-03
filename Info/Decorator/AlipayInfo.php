<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class AlipayInfo extends EnableInfo
{
    /**
     * 支付寶啟用
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ALIPAY' => $this->isEnable? 1: 0,
            ];
    }
}
