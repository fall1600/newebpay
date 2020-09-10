<?php

namespace fall1600\Package\Newebpay;

class Response
{
    /** @var array */
    protected $data;

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
    public function __construct(array $data, string $tradeInfo, string $tradeSha)
    {
        $this->data = $data;

        $this->tradeInfo = $tradeInfo;

        $this->tradeSha = $tradeSha;
    }

    /**
     * 回傳狀態
     *   成功: SUCCESS
     *   失敗: 錯誤代碼
     * @return string
     */
    public function getStatus()
    {
        return $this->data['Status'];
    }

    /**
     * 回傳訊息
     * @return string
     */
    public function getMessage()
    {
        return $this->data['Message'];
    }

    /**
     * 回傳參數細節
     * @return array
     */
    public function getResult()
    {
        return $this->data['Result'];
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
     * 用來跟藍新溝通的訂單編號, 也就是OrderInterface 提供的MerchantOrderNo
     * @return string|null
     */
    public function getMerchantOrderNo()
    {
        return $this->data['Result']['MerchantOrderNo'] ?? null;
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

    /**
     * 離線金流會帶繳費到期日回來, 格式: yyyy-mm-dd
     * @return string|null
     */
    public function getExpireDate()
    {
        return $this->data['Result']['ExpireDate'] ?? null;
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
