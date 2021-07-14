<?php

namespace fall1600\Package\Newebpay;

class PeriodResponse extends Response
{
    /** @var string */
    protected $period;

    /**
     * 注入藍新來的回傳值
     * @param array $data
     * @param string $period
     */
    public function __construct($data, $period)
    {
        parent::__construct($data);
        $this->period = $period;
    }

    /**
     * 商城代號
     * @return string|null
     */
    public function getMerchantId()
    {
        return isset($this->data['Result']['MerchantID']) ? $this->data['Result']['MerchantID'] : null;
    }

    /**
     * 商店自訂的定期定額訂單編號
     * @return string|null
     */
    public function getMerchantOrderNo()
    {
        return isset($this->data['Result']['MerchantOrderNo']) ? $this->data['Result']['MerchantOrderNo'] : null;
    }

    /**
     * 委託單週期
     * @return string|null
     */
    public function getPeriodType()
    {
        return isset($this->data['Result']['PeriodType']) ? $this->data['Result']['PeriodType'] : null;
    }

    /**
     * 授權次數
     * @return int|null
     */
    public function getAuthTimes()
    {
        $times = 0;
        if (isset($this->data['Result']['AuthTimes'])) {
            $times = (int)$this->data['Result']['AuthTimes'];
        }
        return $times;
    }

    /**
     * 授權時間
     * @return string|null
     */
    public function getAuthTime()
    {
        return isset($this->data['Result']['AuthTime']) ? $this->data['Result']['AuthTime'] : null;
    }

    /**
     * 授權排程日期
     * @return string|null
     */
    public function getDateArray()
    {
        return isset($this->data['Result']['DateArray']) ? $this->data['Result']['DateArray'] : null;
    }

    /**
     * 藍新金流交易序號
     * @return string|null
     */
    public function getTradeNo()
    {
        return isset($this->data['Result']['TradeNo']) ? $this->data['Result']['TradeNo'] : null;
    }

    /**
     * 卡號前六後四碼
     * @return string|null
     */
    public function getCardNo()
    {
        return isset($this->data['Result']['CardNo']) ? $this->data['Result']['CardNo'] : null;
    }

    /**
     *  每期金額
     * @return int|null
     */
    public function getPeriodAmt()
    {
        $amt = 0;
        if (isset($this->data['Result']['PeriodAmt'])) {
            $amt = (int)$this->data['Result']['PeriodAmt'];
        }
        return $amt;
    }

    /**
     * 授權碼
     * @return string|null
     */
    public function getAuthCode()
    {
        return isset($this->data['Result']['AuthCode']) ? $this->data['Result']['AuthCode'] : null;
    }

    /**
     * string  // 銀行回應碼
     * @return string|null
     */
    public function getRespondCode()
    {
        return isset($this->data['Result']['RespondCode']) ? $this->data['Result']['RespondCode'] : null;
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
     * 收單機構
     * @return string|null
     */
    public function getAuthBank()
    {
        return isset($this->data['Result']['AuthBank']) ? $this->data['Result']['AuthBank'] : null;
    }

    /**
     * 交易類別
     * @return string|null
     */
    public function getPaymentMethod()
    {
        return isset($this->data['Result']['PaymentMethod']) ? $this->data['Result']['PaymentMethod'] : null;
    }

    /**
     *  委託單號
     * @return string|null
     */
    public function getPeriodNo()
    {
        return isset($this->data['Result']['PeriodNo']) ? $this->data['Result']['PeriodNo'] : null;
    }

    /**
     *  信用卡到期日
     * @return string|null
     */
    public function getExtday()
    {
        return isset($this->data['Result']['Extday']) ? $this->data['Result']['Extday'] : null;
    }
}
