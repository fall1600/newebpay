<?php

namespace fall1600\Package\Newebpay\Info;

use fall1600\Package\Newebpay\NewebPay;

class AliPayBasicInfo extends AliPayInfo
{
    /**
     * @return array
     */
    public function getInfo()
    {
        return [
            // 基本必填
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
            // AliPay 必填
            'Receiver' => $this->payer->getReceiver(),
            'Tel1' => $this->payer->getTel1(),
            'Tel2' => $this->payer->getTel2(),
            'Count' => $this->count,
        ];
    }
}
