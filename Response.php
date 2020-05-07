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
     * @return string
     */
    public function getMerchantId()
    {
        return $this->data['MerchantID'];
    }

    /**
     * 交易金額
     * @return int
     */
    public function getAmt()
    {
        return (int) $this->data['Amt'];
    }

    /**
     * 交易序號
     * @return string
     */
    public function getTradeNo()
    {
        return $this->data['TradeNo'];
    }

    /**
     * 用來跟藍星溝通的訂單編號, 也就是OrderInterface 提供的MerchantOrderNo
     * @return string
     */
    public function getMerchantTradeNo()
    {
        return $this->data['MerchantTradeNo'];
    }

    /**
     * 付款方式
     * @return string
     */
    public function getPaymentType()
    {
        return $this->data['PaymentType'];
    }

    public function getResponseType()
    {
        return $this->data['ResponseType'];
    }

    /**
     * 付款完成時間
     * @return string
     */
    public function getPayTime()
    {
        return $this->data['PayTime'];
    }

    /**
     * 付款人取號或交易時的ip
     * @return string
     */
    public function getIp()
    {
        return $this->data['IP'];
    }

    /**
     * 款項保管銀行
     * @return string
     */
    public function getEscrowBank()
    {
        return $this->data['EscrowBank'];
    }
}
