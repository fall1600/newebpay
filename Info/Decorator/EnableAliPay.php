<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

class EnableAliPay extends Enable
{
    /**
     * 支付寶啟用
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ALIPAY' => $this->isEnable ? 1 : 0,
            ];
    }
}
