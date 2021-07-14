<?php

namespace fall1600\Package\Newebpay;

class TradeInfoResponse extends Response
{
    /** @var string */
    protected $tradeInfo;

    /** @var string */
    protected $tradeSha;

    /**
     * 注入藍新來的回傳值
     * @param array $data
     * @param string $tradeInfo
     * @param string $tradeSha
     */
    public function __construct($data, $tradeInfo, $tradeSha)
    {
        parent::__construct($data);
        $this->tradeInfo = $tradeInfo;

        $this->tradeSha = $tradeSha;
    }

    /**
     * /**
     * 商城代號
     * @return string|null
     */
    public function getMerchantId()
    {
        return isset($this->data['Result']['MerchantID']) ? $this->data['Result']['MerchantID'] : null;
    }

    /**
     * 交易金額
     * @return int|null
     */
    public function getAmt()
    {
        $amt = 0;
        if (isset($this->data['Result']['Amt'])) {
            $amt = (int)$this->data['Result']['Amt'];
        }
        return $amt;
    }

    /**
     * 交易序號
     * @return string|null
     */
    public function getTradeNo()
    {
        return isset($this->data['Result']['TradeNo']) ? $this->data['Result']['TradeNo'] : null;
    }

    /**
     * 用來跟藍新溝通的訂單編號, 也就是OrderInterface 提供的MerchantOrderNo
     * @return string|null
     */
    public function getMerchantOrderNo()
    {
        return isset($this->data['Result']['MerchantOrderNo']) ? $this->data['Result']['MerchantOrderNo'] : null;
    }

    /**
     * 付款方式
     * @return string|null
     */
    public function getPaymentType()
    {
        return isset($this->data['Result']['PaymentType']) ? $this->data['Result']['PaymentType'] : null;
    }

    public function getResponseType()
    {
        return isset($this->data['Result']['ResponseType']) ? $this->data['Result']['ResponseType'] : null;
    }

    /**
     * 付款完成時間
     * @return string|null
     */
    public function getPayTime()
    {
        return isset($this->data['Result']['PayTime']) ? $this->data['Result']['PayTime'] : null;
    }

    /**
     * 付款人取號或交易時的ip
     * @return string|null
     */
    public function getIp()
    {
        return isset($this->data['Result']['IP']) ? $this->data['Result']['IP'] : null;
    }

    /**
     * 款項保管銀行
     * @return string|null
     */
    public function getEscrowBank()
    {
        return isset($this->data['Result']['EscrowBank']) ? $this->data['Result']['EscrowBank'] : null;
    }

    /**
     * 離線金流會帶繳費到期日回來, 格式: yyyy-mm-dd
     * @return string|null
     */
    public function getExpireDate()
    {
        return isset($this->data['Result']['ExpireDate']) ? $this->data['Result']['ExpireDate'] : null;
    }

    /**
     * @return string
     */
    public function getTradeInfo()
    {
        return $this->tradeInfo;
    }

    /**
     * @return string
     */
    public function getTradeSha()
    {
        return $this->tradeSha;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
