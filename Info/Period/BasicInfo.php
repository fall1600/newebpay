<?php

namespace fall1600\Package\Newebpay\Info\Period;

class BasicInfo extends Info
{
    /**
     * @return array
     */
    public function getInfo()
    {
        return [
            'RespondType' => 'JSON',
            'TimeStamp' => time(),
            'Version' => $this->version,
            'MerOrderNo' => $this->order->getMerOrderNo(),
            'ProdDesc' => $this->order->getProdDesc(),
            'PeriodAmt' => $this->order->getAmount(),
            'PeriodType' => $this->order->getPeriodType(),
            'PeriodPoint' => $this->order->getPeriodPoint(),
            'PeriodStartType' => $this->periodStartType,
            'PeriodTimes' => $this->order->getPeriodTimes(),
            'PayerEmail' => $this->contact->getPayerEmail(),
            'EmailModify' => $this->contact->getPayerEmailModify(),
            'PaymentInfo' => $this->contact->getPaymentInfo(),
            'OrderInfo' => $this->contact->getOrderInfo(),
        ];
    }
}
