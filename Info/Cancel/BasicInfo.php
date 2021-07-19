<?php

namespace fall1600\Package\Newebpay\Info\Cancel;

class BasicInfo extends Info
{
    public function getInfo()
    {
        return [
            'ResponseType' => 'JSON',
            'Version' => '1.0',
            'Amt' => $this->order->getAmt(),
            'MerchantOrderNo' => $this->order->getMerchantOrderNo(),
            'TradeNo' => $this->tradeNo,
            //只限定填數字1或2, 1表示使用商店訂單編號, 2表示使用藍新金流交易單號
            'IndexType' => $this->tradeNo? 2: 1,
            'TimeStamp' => time(),
        ];
    }
}
