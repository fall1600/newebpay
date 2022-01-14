<?php

namespace fall1600\Package\Newebpay\Info;

use fall1600\Package\Newebpay\NewebPay;

class BasicInfo extends Info
{
    /**
     * @return array
     */
    public function getInfo()
    {
        return [
            'MerchantID' => $this->merchantId,
            'RespondType' => 'JSON',
            'TimeStamp' => time(),
            'Version' => NewebPay::VERSION,
            'NotifyURL' => $this->notifyUrl,
            'Amt' => $this->order->getAmt(),
            'ItemDesc' => $this->order->getItemDesc(),
            'MerchantOrderNo' => $this->order->getMerchantOrderNo(),
            'Email' => $this->payer->getEmail(),
            'LoginType' => $this->payer->getLoginType() ? 1 : 0,
        ];
    }
}
