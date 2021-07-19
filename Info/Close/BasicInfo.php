<?php

namespace fall1600\Package\Newebpay\Info\Close;

class BasicInfo extends Info
{
    public function getInfo()
    {
        return [
            'RespondType' => 'JSON',
            'Version' => '1.1',
            'Amt' => $this->amt,
            'MerchantOrderNo' => $this->order->getMerOrderNo(),
            'TimeStamp' => time(),
            'IndexType' => $this->indexType,
            'TradeNo' => $this->tradeNo,
            'CloseType' => $this->closeType,
        ];
    }
}
