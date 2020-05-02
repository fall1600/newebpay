<?php

namespace fall1600\Info;

abstract class Info
{
    /**
     * 藍星金流商店代號
     * @var string
     */
    protected $merchantId;

    /**
     * 支付通知網址
     *  藍星背景告知系統支付明細的callback url
     * @var string
     */
    protected $notifyUrl;

    /**
     * @return array
     */
    abstract public function getInfo();

    public function __construct(string $merchantId, string $notifyUrl)
    {
        $this->merchantId = $merchantId;

        $this->notifyUrl = $notifyUrl;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }
}
