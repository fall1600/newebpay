<?php

namespace fall1600\Package\Newebpay;

class Response
{
    /** @var array */
    protected $data;

    public function __construct(string $tradeInfo)
    {
        $this->data = json_decode($tradeInfo, true);
    }

    /**
     * 商城代號
     * @return string|null
     */
    public function getMerchantId()
    {
        return $this->data['Result']['MerchantID'] ?? null;
    }

    /**
     * 交易金額
     * @return int|null
     */
    public function getAmt()
    {
        return ((int) $this->data['Result']['Amt']) ?? null;
    }

    /**
     * 交易序號
     * @return string|null
     */
    public function getTradeNo()
    {
        return $this->data['Result']['TradeNo'] ?? null;
    }

    /**
     * 用來跟藍星溝通的訂單編號, 也就是OrderInterface 提供的MerchantOrderNo
     * @return string|null
     */
    public function getMerchantTradeNo()
    {
        return $this->data['Result']['MerchantTradeNo'] ?? null;
    }

    /**
     * 付款方式
     * @return string|null
     */
    public function getPaymentType()
    {
        return $this->data['Result']['PaymentType'] ?? null;
    }

    public function getResponseType()
    {
        return $this->data['Result']['ResponseType'] ?? null;
    }

    /**
     * 付款完成時間
     * @return string|null
     */
    public function getPayTime()
    {
        return $this->data['Result']['PayTime'] ?? null;
    }

    /**
     * 付款人取號或交易時的ip
     * @return string|null
     */
    public function getIp()
    {
        return $this->data['Result']['IP'] ?? null;
    }

    /**
     * 款項保管銀行
     * @return string|null
     */
    public function getEscrowBank()
    {
        return $this->data['Result']['EscrowBank'] ?? null;
    }
}
